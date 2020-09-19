<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Notifications\group_join_request;
use App\Notifications\join_request_approved;
use App\Notifications\send_pub_invite_noti;
use App\Notifications\send_priv_invite_noti;
use App\Notifications\priv_group_invite_accepted;
use App\User;
use App\Group;
use App\Profile;
use App\GroupPosts;

class GroupController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$groups = Profile::find(Auth::id())->groups;
		return view('group.index', compact('groups'));
	}

	public function create(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|max:255|unique:App\Group,name',
			'category' => 'required',
			'description' => 'required|max:255'
		]);

		$privacy = ($request->has('privacy')) ? 1 : 0;

		$group_data = array_merge($data, ["privacy" => $privacy]);

		$group = Group::create($group_data);

		$admin_profile = Profile::where('user_id', Auth::id())->get();

		$group->admin()->attach($admin_profile);

		return redirect()->back();
	}

	public function home(Group $group)
	{
		return view('group.home', compact('group'));
	}

	public function edit(Group $group)
	{
		return view('group.edit', compact('group'));
	}

	public function update(Request $request, Group $group)
	{
		$data = $request->validate([
    		'name' => 'required|max:255',
    		'description' => 'required|max:255',
            'groupPhoto' => '',
    	]);
    	
        if($request->groupPhoto)
        {
            $imagePath = $request->groupPhoto->store('group', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);

            $image->save();

            $imgArr = ['groupPhoto' => $imagePath];
        }

        $group_update_data = array_merge($data, $imgArr ?? []);

    	Group::find($group->id)->update($group_update_data); 

        return redirect(route('group.home', $group));
	}


	public function post_panel(Group $group)
	{
		return view('group.post-panel', compact('group'));
	}

	public function member_panel(Group $group)
	{
		return view('group.member-panel', compact('group'));
	}

	public function admin_panel(Group $group)
	{
		return view('group.admin-list', compact('group'));
	}

	public function joined_groups()
	{
		$groups = auth()->user()->profile->member_of_groups;

		return view('group.joined', compact('groups'));
	}

	public function g_member_profile(User $user)
	{
		$profile = $user->profile;

		$p_member = $profile->member_of_groups->where('privacy', 0);
		
		return view('group.view-member-groups', compact('p_member', 'user'));
	}

	public function g_create_profile(User $user)
	{
		$profile = $user->profile;

		$p_admin = $profile->groups->where('privacy', 0);
		
		return view('group.view-groups', compact('p_admin', 'user'));
	}

	public function make_admin(Profile $member, Group $group)
	{	
		// dd([$member, $group]);
		$group->admin()->attach($member);
		$group->member()->detach($member);
		return redirect()->back();
	}

	public function remove_member(Profile $member, Group $group)
	{
		$group->member()->detach($member);	
		return redirect()->back();
	}

	public function remove_admin(Profile $admin, Group $group)
	{
		$group->admin()->detach($admin);
		$group->member()->attach($admin);
		return redirect()->back();
	}

	public function search_member(Request $request)
	{

		$users = DB::table('member_group')
					->join('profiles', 'member_group.profile_id', '=', 'profiles.id')
					->join('users', 'users.id', '=', 'profiles.user_id')
					->where([
		                    ['name', 'like', '%'. $request->search_query .'%'],
		                    ['group_id', '=', $request->group_id],
	                	])
					->limit(20)
					->get();

		$data = array();

		foreach ($users as $user) {
			array_push($data, [
				'name' => $user->name,
				'profession' => $user->profession,
				'image' => $user->image,
				'profile_id' => $user->profile_id,
				'user_id' => $user->user_id,
				'group_id' => $user->group_id
			]);
		}

        return json_encode($data);
	}

	public function send_join_notification(User $user, Group $group)
	{
		$group->notify(new group_join_request($user));

		// will insert a flag where $user sends a join request to a $group
		DB::table('group_notification_flag')->insert(['group_id' => $group->id, 'user_id' => $user->id, 'sent' => 1]);

		return redirect()->back();
	}

	public function join_requests(Group $group)
	{
		return view('group.requests-panel', compact('group'));
	}

	public function approve_request(Group $group, User $user, $notif)
	{
		$group->member()->attach($user->profile);

		$group->notifications()->where('id', $notif)->delete();

		DB::table('group_notification_flag')->where(['group_id' => $group->id, 'user_id' => $user->id])->delete();

		//send notif to $user that their membership is approved
		$user->notify(new join_request_approved($user, $group));

		return redirect()->back();
	}

	public function cancel_request(User $user, Group $group)
	{
		$group->notifications()->where([['notifiable_id', '=', $group->id], ['data', '=', json_encode(['user'=>$user])]])->delete();

		DB::table('group_notification_flag')->where(['group_id' => $group->id, 'user_id' => $user->id])->delete();

		return redirect()->back();
	}

	public function noti() 
	{ 
		$join_request = Auth::user()->notifications()->where('type', "App\Notifications\join_request_approved")->get();
		
		$pub_inv = Auth::user()->notifications()->where('type', "App\Notifications\send_pub_invite_noti")->get();

		$priv_inv = Auth::user()->notifications()->where('type', "App\Notifications\send_priv_invite_noti")->get();

		$pri_grp_inv_accp = Auth::user()->notifications()->where('type', "App\Notifications\priv_group_invite_accepted")->get();

		$notifications = $join_request->merge($pub_inv)->merge($priv_inv)->merge($pri_grp_inv_accp);

		return view('group.notifications', compact('notifications')); 
	}

	public function mark_as_read($notif)
	{
		Auth::user()->notifications()->where('id', $notif)->get()->markAsRead();
		
		return redirect()->back();
	}

	public function remove_noti($notif)
	{
		$noti = Auth::user()->notifications()->where('id', $notif)->get(['type', 'data']);

		if ($noti[0]['type'] == 'App\Notifications\send_pub_invite_noti')
		{
			DB::table('public_invite_sent_flag')->where([['sender_id', '=', $noti[0]['data']['sender']], ['recipient_id', '=', $noti[0]['data']['recipient']], ['group_id', '=', $noti[0]['data']['group']]])->delete();	
		}
	
		Auth::user()->notifications()->where('id', $notif)->delete();

		return redirect()->back();
	}

	public function invite_public(Group $group)
	{	
		return view('group.public-invite', compact('group'));
	}

	public function public_invite_search(Request $request)
	{
		// public group invites can only be sent to the users follower
		$followers = Auth::user()->profile->followers()->where('name', 'like', '%' . $request->search_query . '%')->get();

		$data = array();

		$group = Group::find($request->group_id);

		foreach($followers as $follower)
		{
			$sent = (DB::table('public_invite_sent_flag')->where([['sender_id', '=', Auth::id()], ['recipient_id', '=', $follower->id], ['group_id', '=', $request->group_id]])->value('sent')) ? true : false;

			// demorgan is your buddy!
			if(!($group->member->contains($follower->profile) || $group->admin->contains($follower->profile)))
			{
				array_push($data, [
					'recipient_uid' => $follower->id,
					'recipient_name' => $follower->name,
					'recipient_pi' => $follower->profile->profileImage(),
					'sender_uid' => Auth::id(),
					'group_id' => $request->group_id,
					'sent' => $sent,
				]);
			}
		}

		return json_encode($data);
	}

	public function private_invite_search(Request $request)
	{
		$user = Auth::user()->where('name', 'like', '%' . $request->search_query . '%')->get();

		$data = array();

		$group = Group::find($request->group_id);

		foreach($user as $user)
		{
			$sent = (DB::table('private_invite_sent_flag')->where([['sender_id', '=', Auth::id()], ['recipient_id', '=', $user->id], ['group_id', '=', $request->group_id]])->value('sent')) ? true : false;

			// demorgan is your buddy!
			if(!($group->member->contains($user->profile) || $group->admin->contains($user->profile)))
			{
				array_push($data, [
					'recipient_uid' => $user->id,
					'recipient_name' => $user->name,
					'recipient_pi' => $user->profile->profileImage(),
					'sender_uid' => Auth::id(),
					'group_id' => $request->group_id,
					'sent' => $sent,
				]);
			}
		}

		return json_encode($data);
	}

	public function send_pub_invite_noti(User $sender, User $recipient, Group $group)
	{
		$recipient->notify(new send_pub_invite_noti($sender, $recipient, $group));

		// will insert a flag where $sender send an invite to a $recipient to join $group
		DB::table('public_invite_sent_flag')->insert(['sender_id' => $sender->id, 'recipient_id' => $recipient->id, 'group_id' => $group->id, 'sent' => 1]);

		return redirect()->back()->with('success', 'Invite has been sent to '.$recipient->name);
	}

	public function send_priv_invite_noti(User $sender, User $recipient, Group $group)
	{
		$recipient->notify(new send_priv_invite_noti($sender, $recipient, $group));

		// will insert a flag where $sender send an invite to a $recipient to join $group
		DB::table('private_invite_sent_flag')->insert(['sender_id' => $sender->id, 'recipient_id' => $recipient->id, 'group_id' => $group->id, 'sent' => 1]);

		return redirect()->back()->with('success', 'Invite has been sent to '.$recipient->name);
	}

	public function get_sent_invites()
	{
		//
	}

	public function remove_sent_invite()
	{
		//
	}

	public function accept_invite($notif){

		// once the invite is accepted, the notification is gone.

		$noti = Auth::user()->notifications()->where('id', $notif)->get(['type', 'data']);

		Group::find($noti[0]['data']['group'])->member()->attach(User::find($noti[0]['data']['recipient'])->profile);

		// send a accepted notifications back
		User::find($noti[0]['data']['sender'])->notify(new priv_group_invite_accepted(Auth::user()->id, $noti[0]['data']['sender'], $noti[0]['data']['group']));

		DB::table('private_invite_sent_flag')->where([['sender_id', '=', $noti[0]['data']['sender']], ['recipient_id', '=', $noti[0]['data']['recipient']], ['group_id', '=', $noti[0]['data']['group']]])->delete();	

		Auth::user()->notifications()->where('id', $notif)->delete();

		return redirect()->back();

	}

	//////////// group posts related methods ////////////////

	public function p_create(Request $request)
	{
		$data = $request->validate([
       		'content' => 'required|max:255',
       		'attachment' => '',
       	]);

        if($request->hasFile('attachment'))
        {
        	$attachment = array();

        	$allowedImgFileExtension=['jpeg','jpg','png','webp'];
        	$files = $request->file('attachment');

        	foreach ($files as $file) {

        		$file_name = $file->getClientOriginalName();
        		$extension = $file->getClientOriginalExtension();
        		$file_size = $file->getSize();

        		if($file_size < 10000000)
        		{
        			if (in_array($extension, $allowedImgFileExtension))
	        		{
	    			    $imagePath = $file->store('group/group_posts', 'public');

	    			    $image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);

	    			    $image->save();

	        			array_push($attachment, $imagePath);
	        		}

	        		else
	        		{
	        			return redirect()->back()->with('error', 'Only jpeg, pdf, png, jpg files accepted.');
	        		}
        		}
        		else 
        		{
        			return redirect()->back()->with('error', 'Files cannot exceed 10MB.', array('timeout' => 3000));
        		}
        	}

        	$attachment = collect($attachment);
        }
		
		$group_post_data = array_merge($data, ['attachment' => $attachment ?? null, 'user_id' => Auth::id(), 'group_id' => (int)$request->group_id]);
    	
    	$group_post = GroupPosts::create($group_post_data); 

        return redirect()->back()->with('success', 'Your post was successful!');
	}

	public function upload_docfiles(Group $group)
	{
		return view('group.upload-docfiles', compact('group'));
	}

	public function save_docfiles(Request $request)
	{

		$data = $request->validate([
       		'content' => 'required|max:255',
       		'files' => '',
       	]);

		if($request->hasFile('files'))
		{
			$files_col = array();

			$allowedDocFileExtension = ['xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'pdf', 'zip'];
			$files = $request->file('files');

			foreach($files as $file)
			{
				$file_name = $file->getClientOriginalName();
        		$extension = $file->getClientOriginalExtension();
        		$file_size = $file->getSize();

        		if($file_size < 15000000)
        		{
        			if (in_array($extension, $allowedDocFileExtension))
	        		{
	    				$file_name_in_storage = time() . '@' . $file_name;
	    				           
	    				$path = $file->storeAs('public/group/group_posts/files',$file_name_in_storage);

	    				array_push($files_col, $file_name_in_storage);
	        		}
	        		else
	        		{
	        			return redirect()->back()->with('error', 'Only xlsx, xls, doc, docx, ppt, pptx, txt, pdf, zip accepted.');
	        		}
        		}
        		else 
        		{
        			return redirect(route('group.home', $request->group_id))->with('error', 'Files cannot exceed 15MB.');
        		}
			}

			$files_col = collect($files_col);

		}

		$group_post_data = array_merge($data, ['files' => $files_col ?? null, 'user_id' => Auth::id(), 'group_id' => (int)$request->group_id]);
    	
    	$group_post = GroupPosts::create($group_post_data); 

        return redirect(route('group.home', $request->group_id))->with('success', 'Your post was successful');

	}

	public function file_download($file)
	{
		return response()->download(storage_path('app/public/files/' . $file));
	}


}






















