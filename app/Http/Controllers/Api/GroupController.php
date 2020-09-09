<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $groups = $request->user()->groups()->orderBy('updated_at', 'DESC')->get();
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupRequest $request)
    {
        // Validation done via GroupRequest
        $validated_data = $request->validated();
        $group = new Group($validated_data);
        Auth::user()->groups()->save($group);
        return response()->json(['message' => 'Group Created', 'group' => new GroupResource($group)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Group $group
     * @return GroupResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Group $group)
    {
        $this->authorize('view', $group);
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Group $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);
        // Validation done via GroupRequest
        $validated_data = $request->validated();
        $group->update($validated_data);
        return response()->json(['message' => 'Group Updated', 'group' => new GroupResource($group)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Group $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->delete();
        return response()->json(['message' => 'Group Deleted'], 200);
    }
}
