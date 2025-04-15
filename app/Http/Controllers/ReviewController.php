<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Book;
class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);

    $review = Review::create([
        'user_id' => $request->user()->id,
        'book_id' => $bookId,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json(['message' => 'Review submitted', 'review' => $review]);
}

public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);

    if ($request->user()->id !== $review->user_id) {
        return response()->json(['message' => 'Review Does not belongs to you'], 403);
    }

    $request->validate([
        'rating' => 'sometimes|integer|min:1|max:5',
        'comment' => 'sometimes|string',
    ]);

    $review->update($request->only(['rating', 'comment']));

    return response()->json(['message' => 'Review updated', 'review' => $review]);
}

public function destroy(Request $request, $id)
{
    $review = Review::findOrFail($id);

    if ($request->user()->id !== $review->user_id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $review->delete();

    return response()->json(['message' => 'Review deleted']);
}
}
