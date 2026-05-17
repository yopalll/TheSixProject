<?php

namespace App\Models;

<<<<<<< HEAD:BelajarKUY /app/Models/Category.php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
=======
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

>>>>>>> f7f211c5c2bc7355e3deca1280430c8b4026948d:BelajarKUY/app/Models/Category.php
    protected $fillable = [
        'name',
        'slug',
        'image',
<<<<<<< HEAD:BelajarKUY /app/Models/Category.php
        'description',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
=======
        'status',
    ];

>>>>>>> f7f211c5c2bc7355e3deca1280430c8b4026948d:BelajarKUY/app/Models/Category.php
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

<<<<<<< HEAD:BelajarKUY /app/Models/Category.php
    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
=======
    // ========================= RELATIONSHIPS =========================

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    // ============================ SCOPES =============================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
>>>>>>> f7f211c5c2bc7355e3deca1280430c8b4026948d:BelajarKUY/app/Models/Category.php
    }
}
