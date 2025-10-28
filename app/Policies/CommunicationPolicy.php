<?php

namespace App\Policies;

use App\Models\Communication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any communications.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view communications');
    }

    /**
     * Determine whether the user can view the communication.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Communication $communication)
    {
        return $user->hasPermissionTo('view communications');
    }

    /**
     * Determine whether the user can create communications.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create communications');
    }

    /**
     * Determine whether the user can update the communication.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Communication $communication)
    {
        return $user->hasPermissionTo('edit communications') && $communication->status === 'draft';
    }

    /**
     * Determine whether the user can delete the communication.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Communication $communication)
    {
        return $user->hasPermissionTo('delete communications');
    }

    /**
     * Determine whether the user can send communications.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function send(User $user, Communication $communication)
    {
        return $user->hasPermissionTo('send communications') && $communication->status === 'draft';
    }
}