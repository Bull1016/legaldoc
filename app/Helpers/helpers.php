<?php

use App\Models\Exercice;
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

    $presidentRole = Role::updateOrCreate([
      'name' => 'Président'
    ], [
      'name' => 'Président',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpeRole = Role::updateOrCreate([
      'name' => 'Vice Président Exécutif'
    ], [
      'name' => 'Vice Président Exécutif',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $sgRole = Role::updateOrCreate([
      'name' => 'Secrétaire Général'
    ], [
      'name' => 'Secrétaire Général',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $tgRole = Role::updateOrCreate([
      'name' => 'Trésorier Général'
    ], [
      'name' => 'Trésorier Général',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $cjRole = Role::updateOrCreate([
      'name' => 'Conseiller Juridique'
    ], [
      'name' => 'Conseiller Juridique',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpaeRole = Role::updateOrCreate([
      'name' => 'Vice Président Affaire et Entrepreneuriat'
    ], [
      'name' => 'Vice Président Affaire et Entrepreneuriat',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpcmRole = Role::updateOrCreate([
      'name' => 'Vice Président Communication et Marketing'
    ], [
      'name' => 'Vice Président Communication et Marketing',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpcdRole = Role::updateOrCreate([
      'name' => 'Vice Président Croissance et Développement'
    ], [
      'name' => 'Vice Président Croissance et Développement',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpfRole = Role::updateOrCreate([
      'name' => 'Vice Président Formation'
    ], [
      'name' => 'Vice Président Formation',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpmRole = Role::updateOrCreate([
      'name' => 'Vice Président Management'
    ], [
      'name' => 'Vice Président Management',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vptpRole = Role::updateOrCreate([
      'name' => 'Vice Président Projet et Theme Principal'
    ], [
      'name' => 'Vice Président Projet et Theme Principal',
      'string_id' => Str::uuid(),
      'guard_name' => 'web',
    ]);

    $vpreRole = Role::updateOrCreate([
      'name' => 'Vice Président Relations Extérieures'
    ], [
      'name' => 'Vice Président Relations Extérieures',
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

      // DOCUMENTS
      ['name' => 'documents.index'],
      ['name' => 'documents.create'],
      ['name' => 'documents.edit'],
      ['name' => 'documents.destroy'],

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

