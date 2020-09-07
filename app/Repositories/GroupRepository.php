<?php


namespace App\Repositories;


use App\Group;
use Illuminate\Support\Facades\Auth;

class GroupRepository
{
    // Get groups for authenticated user
    public function myGroups()
    {
        return Auth::user()->groups;
    }

    // Create a new group
    public function createGroup($data)
    {
        $group = new Group;
        $group->name = $data["name"];
        $group->description = $data["description"];
        $group->user_id = Auth::id();
        $group->save();
        return $group;
    }

    // Update existing group
    public function updateGroup($group_id, $data)
    {
        $group = Group::find($group_id);
        $group->name = $data["name"];
        $group->description = $data["description"];
        $group->save();
        return $group;
    }

    // Delete group
    public function deleteGroup($group_id)
    {
        Group::find($group_id)->delete();
        return 'Group Deleted!';
    }
}
