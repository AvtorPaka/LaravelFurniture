<?php

namespace App\Models;

use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $price
 * @property int|null $category_id
 * @property-read \App\Models\Category|null $category
 * @property-read float $average_rating
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GoodRating> $ratings
 * @property-read int|null $ratings_count
 * @method static \Database\Factories\FurnitureGoodFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FurnitureGood wherePrice($value)
 * @mixin \Eloquent
 */
class FurnitureGood extends Model implements Cartable
{
    use HasFactory;

    protected $table = 'furniture_goods';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(GoodRating::class, 'good_id');
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) $this->ratings()->avg('rating') ?? 0;
    }

    public function userRating(): HasOne
    {
        return $this->hasOne(GoodRating::class, 'good_id')
            ->where('user_id', auth()->id());
    }

    public function getUserRatingAttribute()
    {
        return $this->userRating ?? $this->userRating()->first();
    }
}
