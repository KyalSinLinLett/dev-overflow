<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Notifications\group_join_request;
use App\User;
use App\Group;
use App\Profile;

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
		// dd($request->name . $request->description . $request->image);

		$data = $request->validate([
    		'name' => 'required|max:255',
    		'description' => 'required|max:255',
            'groupPhoto' => '',
    	]);

    	// dd($data);
    	
        if($request->groupPhoto)
        {
            $imagePath = $request->groupPhoto->store('group', 'public');

            $imagePath;

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

}
