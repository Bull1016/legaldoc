<?php

namespace App\Models;

use App\Models\User;
use App\Models\Member;
use App\Models\Social;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Organisation extends Model
{
  use HasFactory;
  protected $table = 'organisations';
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'nameOr',
    'descriptionOr',
    'mailOr',
    'numberOr',
    'stateOr',
    'picOr',
    'user_id',
    'town_id',
    'country_id',
    'social_id',
    'latitude',
    'longitude',
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

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function town()
  {
    return $this->belongsTo(Town::class);
  }

  public function social()
  {
    return $this->belongsTo(Social::class);
  }

  public function members()
  {
    return $this->hasMany(Member::class);
  }
}
