<?php

namespace App\Http\Controllers;

use App\Models\FurnitureGood;
use App\Models\GoodRating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GoodRatingController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:ratings.modify', only: ['addOrUpdate', 'destroy']),
        ];
    }
    public function addOrUpdate(Request $request, FurnitureGood $good)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = GoodRating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'good_id' => $good->id
            ],
            [
                'rating' => $validated['rating']
            ]
        );

        $message = $rating->wasRecentlyCreated ? 'Thank you for rating the product!' : 'Your product rating has been updated.!';

        return redirect()->back()
            ->with('success', $message);
    }

    public function destroy(GoodRating $rating)
    {
        $rating->delete();

        return redirect()->back()
            ->with('success', 'Rating deleted.');
    }
}
