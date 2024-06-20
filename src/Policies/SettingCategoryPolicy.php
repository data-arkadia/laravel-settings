<?php

namespace DataArkadia\LaravelSettings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use DataArkadia\LaravelSettings\Models\SettingCategory;

class SettingCategoryPolicy
{
    use HandlesAuthorization;

    public function before()
    {
        if (config('laravel-settings.categories.areManageable')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\SettingCategory  $settingCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(mixed $user, SettingCategory $settingCategory)
    {
        //
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
     * @param  \App\Models\SettingCategory  $settingCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(mixed $user, SettingCategory $settingCategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\SettingCategory  $settingCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(mixed $user, SettingCategory $settingCategory)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\SettingCategory  $settingCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(mixed $user, SettingCategory $settingCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  mixed  $user
     * @param  \App\Models\SettingCategory  $settingCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(mixed $user, SettingCategory $settingCategory)
    {
        //
    }
}
