<?php

namespace App\Models;

use App\Models\Town;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nameCountry',
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

    public function towns(){
        return $this->hasMany(Town::class);
    }
}
