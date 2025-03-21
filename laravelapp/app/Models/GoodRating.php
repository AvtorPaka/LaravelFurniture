<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property int $good_id
 * @property int $rating
 * @property-read \App\Models\FurnitureGood $good
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoodRating whereUserId($value)
 * @mixin \Eloquent
 */
class GoodRating extends Model
{
    protected $table = 'good_ratings';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'good_id',
        'rating'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function good(): BelongsTo
    {
        return $this->belongsTo(FurnitureGood::class, 'good_id');
    }
}
