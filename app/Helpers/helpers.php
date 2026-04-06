<?php

use App\Models\ExerciceTeam;
use App\Models\Member;
use App\Models\Organisation;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('create_update_permissions')) {
  function create_update_permissions()
  {
    $superadminRole = Role::updateOrCreate([
      'name' => 'superadmin'
    ], [
      'name' => 'superadmin',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $memberRole = Role::updateOrCreate([
      'name' => 'member'
    ], [
      'name' => 'member',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $juristeRole = Role::updateOrCreate([
      'name' => 'juriste'
    ], [
      'name' => 'juriste',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $permissions = [
      ['name' => 'dashboard'],

      // ORGANISATIONS
      ['name' => 'organisations.index'],
      ['name' => 'organisations.create'],
      ['name' => 'organisations.edit'],
      ['name' => 'organisations.destroy'],

      // MEMBERS
      ['name' => 'members.index'],
      ['name' => 'members.create'],
      ['name' => 'members.edit'],
      ['name' => 'members.destroy'],

      // SERVICES
      ['name' => 'services.index'],
      ['name' => 'services.create'],
      ['name' => 'services.edit'],
      ['name' => 'services.destroy'],

      // MY REQUESTS
      ['name' => 'my-requests.index'],
      ['name' => 'my-requests.create'],
      ['name' => 'my-requests.edit'],
      ['name' => 'my-requests.destroy'],

      // USERS
      ['name' => 'users.index'],
      ['name' => 'users.create'],
      ['name' => 'users.edit'],
      ['name' => 'users.destroy'],

      // POSTES (ROLES)
      ['name' => 'positions.index'],
      ['name' => 'positions.create'],
      ['name' => 'positions.edit'],
      ['name' => 'positions.destroy'],
    ];

    foreach ($permissions as $permission) {
      Permission::updateOrCreate($permission, $permission);
    }

    $superadminRole->syncPermissions(Permission::all());

    $memberRole->givePermissionTo([
      Permission::where('name', 'dashboard')->first(),
    ]);

    $juristeRole->givePermissionTo([
      Permission::where('name', 'dashboard')->first(),
    ]);
  }
}

if (!function_exists('showAsterix')) {
  function showAsterix($field)
  {
    return '<abbr class="text-danger" data-id="' . $field . '" title="' . __('Mandatory') . '">*</abbr>';
  }
}

if (!function_exists('formatDate')) {
  function formatDate($date)
  {
    $locale = app()->getLocale();
    if ($locale === 'en')
      return Carbon::parse($date)->format('Y-m-d');
    else
      return Carbon::parse($date)->format('d/m/Y');
  }
}

if (!function_exists('getCurrentOrganisation')) {
  function getCurrentOrganisation()
  {
    return Organisation::first();
  }
}

