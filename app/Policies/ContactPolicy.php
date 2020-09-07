<?php

namespace App\Policies;

use App\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function view(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot view this contact since you are not the owner.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function update(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot update this contact since you are not the owner.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id
            ? Response::allow()
            : Response::deny('Sorry, you cannot delete this contact since you are not the owner.');
    }
}
