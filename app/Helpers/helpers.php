<?php

use App\Models\Role;
use App\Models\Setting;
use App\Models\User;

if (! function_exists('getBusinessRoles'))
{
    /**
     * Fetch all roles for a given business
     *
     * @param int $businessId
     * @return \Illuminate\Support\Collection
     */
    function getBusinessRoles($businessId)
    {
        $roles = Role::where('business_id', $businessId);
        $busAdmin = User::where('isBusinessAccount', true)
            ->where('business_id', $businessId)->first();
        if (!session('impersonator_id') && $busAdmin)
        {
            $roles = $roles->where('id', '<>', $busAdmin->role_id);
        }
        return ($roles->get()->pluck('name', 'id'));
    }
}

if (! function_exists('mySettings'))
{
    function mySettings($bId)
    {
        $settings = Setting::where('business_id', $bId)->first();
        if (!$settings)
            $settings = new Setting();
        return $settings;
    }
}
