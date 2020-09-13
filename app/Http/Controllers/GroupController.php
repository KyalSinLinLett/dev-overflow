<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
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

	public function joined_groups()
	{
		$groups = auth()->user()->profile->member_of_groups;

		return view('group.joined', compact('groups'));
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

}
