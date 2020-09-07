<?php

namespace App\Policies;

use App\Group;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return $user->id === $group->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot view this group since you are not the owner.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return $user->id === $group->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot update this group since you are not the owner.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return $user->id === $group->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot delete this group since you are not the owner.');
    }

}
