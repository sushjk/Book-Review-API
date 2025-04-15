<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 📚 List all books (optional, public access if needed)
    public function index(Request $request)
    {
        //return Book::all('id','title');

        $query = Book::query();

    // Apply filters if query parameters are present
    if ($request->has('author')) {
        $query->where('author', 'like', '%' . $request->author . '%');
    }

    if ($request->has('genre')) {
        $query->where('genre', 'like', '%' . $request->genre . '%');
    }

    //return response()->json($query->get());
    //$books = $query->paginate(5);
    $perPage = $request->get('per_page', 10);
    $books = $query->paginate($perPage);
    return response()->json($books);

    }

    public function show($id)
{
    $book = Book::with(['reviews.user'])->find($id);

    if (!$book) {
        return response()->json(['message' => 'Book not found'], 404);
    }

    // Calculate average rating
    $averageRating = $book->reviews()->avg('rating');

    return response()->json([
        'book' => $book,
        'average_rating' => round($averageRating, 2),
        'reviews' => $book->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        }),
    ]);
}


    // ➕ Create a new book
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'author'      => 'required|string',
            'published_year' => 'required|integer',
            'genre'          => 'required|string',
        ]);

        $book = Book::create([
            'title'          => $request->title,
            'author'         => $request->author,
            'published_year' => $request->published_year,
            'genre'          => $request->genre,
            'admin_id'       => $request->user()->id, // auto-assign admin ID
        ]);

        return response()->json(['message' => 'Book created', 'book' => $book]);
    }

    // 🔄 Update book
    public function update(Request $request, Book $book)
    {
        // Check if the authenticated user is the one who created the book
    if ($request->user()->id !== $book->admin_id) {
        return response()->json(['message' => 'You are not authorized to update this book.'], 403);
    }


        $request->validate([
            'title'       => 'required|string',
            'author'      => 'required|string',
            'published_year' => 'required|integer',
            'genre'          => 'required|string',
        ]);

        $book->update([
            'title'          => $request->title,
            'author'         => $request->author,
            'published_year' => $request->published_year,
            'genre'          => $request->genre,
            'last_updated_by' => $request->user()->id,
        ]);


        return response()->json(['message' => 'Book updated', 'book' => $book]);
    }

    // ❌ Delete book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }
}
