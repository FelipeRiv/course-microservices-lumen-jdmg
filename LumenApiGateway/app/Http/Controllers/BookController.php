<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\AuthorService;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Traits\ApiResponser;


class BookController extends Controller
{

    use ApiResponser;

    /**
     * The service to consume the Book service
     * @var BookService
     */
    public $bookService;
    /**
     * The service to consume the Author service
     * @var AuthorService
     */
    public $authorService;

    /**
     * Creates a new controller instance.
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        // this is going to use Services/BookService;
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Retrieve and show all the books
     * @return Illuminate\Http\Response
     */
    public function index(){
        return $this->successResponse($this->bookService->obtaingBooks());
    }

    /**
     * Create an instance of book
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request){

        // ? Video Sí deja crear libro sin author

        // $this->authorService->obtainAuthor($request->author_id);
        // return $this->successResponse($this->bookService->createBook($request->all()), Response::HTTP_CREATED  );

        // -- Alternativa para no dejar crear libro

        $authorID = $request->get('author_id');
        $authorResponse = $this->authorService->obtainAuthor($authorID);
        
        if (str_contains($authorResponse, 'error')) {
            
            // var_dump($authorResponse);

            return $this->errorMessage($authorResponse, Response::HTTP_NOT_FOUND);
        }else{
            
            return $this->successResponse($this->bookService->createBook($request->all()));
        }


    }

    /**
     * Show an instance of book 
     * @return Illuminate\Http\Response 
     */
    public function show($book){
        return $this->successResponse($this->bookService->obtaingBook($book));
    }

    /**
     * Updates an instance of book
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $book){
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }


    
    /**
     * Removes an instance of book
     * @return Illuminate\Http\Response 
     */
    public function destroy($book){
        return $this->successResponse($this->bookService->deleteBook($book));
    }

}
