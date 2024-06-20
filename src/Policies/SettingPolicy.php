<?php

namespace DataArkadia\LaravelSettings\Policies;

use DataArkadia\LaravelSettings\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(mixed $user, Setting $setting)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(mixed $user, Setting $setting)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(mixed $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(mixed $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(mixed $user, Setting $setting)
    {
        //
    }
}
