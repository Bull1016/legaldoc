<?php

namespace App\Models;

use App\Models\User;
use App\Models\Town;
use App\Models\Activity;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'phone',
        'photo',
        'job',
        'birth',
        'organisation_id',
        'user_id',
        'sex'
    ];

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

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function towns()
    {
        return $this->hasMany(Town::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }
}
