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
            'collected', ['boolean'],
            'read', ['boolean'],
            'isbn' => ['required']
        ]);

        //check if we have it stored already
        $bookExists = Book::where(
            'isbn',
            $validated['isbn']
        )->exists();

        if(!$bookExists) {
            $bookController = new BookController();
            $bookController->store($request);
        }

        $userBook = UserBook::firstOrCreate(
            [
                'user_id' => $validated['user_id'],
                'isbn' => $validated['isbn']
            ],
            $validated
        );

        return response($userBook, 200);
    }
}
