<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Country;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Town extends Model
{
    use HasFactory;
    protected $table = 'towns';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nameTown',
        'vpn_id',
        'country_id'
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

    public function organisations(){
        return $this->hasMany(Organisation::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'vpn_id');
    }
}
