<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UserBook;

class UserBookController extends Controller
{
    public function index(Request $request)
    {

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', Rule::in([$request->user()->id])],
            'book_id' => [
                'required',
                'exists:books,id',
                Rule::unique('user_books')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->input('user_id'));
                }),
            ],
        ]);

        $userBook = UserBook::firstOrCreate(
            [
                'user_id' => $validated['user_id'],
                'book_id' => $validated['book_id']
            ],
            $validated
        );

        return response($userBook, 200);
    }
}
