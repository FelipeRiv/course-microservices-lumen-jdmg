<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Book;

class BookController extends Controller
{
        
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return book list
     * @return list of books
     */
    public function index(){
        $books = Book::all();

        return $this->successResponse($books);
        
    }

    /**
     * Create an instance of book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return  $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Return a specific book
     * @return Illuminate\Http\Response
     */
    public function show($book){
        $book = Book::findOrFail($book);

        return $this->successResponse($book);
    }

    /**
     * Update a specific book
     * @return Illuminate\Http\Response
     */
    public function edit(){

    }

    /**
     * Update the information of an existing book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];

        $this->validate($request, $rules);

        // checks if the book exists
        $book = Book::findOrFail($book);

        // fill the book with the request info if that book exists
       $book->fill($request->all());

        // if the book is clean and therefore it has not change, we wont do any action in the DB
        if ($book->isClean()) {
           return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // if the book values request has changed then we will update save the record
        $book->save();

        return $this->successResponse($book);
    }


    /**
     * Removes an existing book 
     * @return Illuminate\Http\Response
     */
    public function destroy(Request $request, $book){
        
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successResponse($book);
    }

}
