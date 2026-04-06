<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Project;
use App\Models\FlashInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'nameCat',
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
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post', 'categorie_id', 'post_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function information()
    {
        return $this->hasOne(FlashInfo::class);
    }
}
