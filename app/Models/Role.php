<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasPermissions;

class Role extends Model
{
    use HasFactory, HasPermissions;

    protected $fillable = ['name', 'guard_name'];
    protected $guard_name = 'web';

    protected static function booted()
    {
        self::creating(function ($instance) {
            $instance->string_id = Str::uuid();
        });

        self::updating(function ($instance) {
            if (!$instance->string_id) {
                $instance->string_id = Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'string_id';
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
