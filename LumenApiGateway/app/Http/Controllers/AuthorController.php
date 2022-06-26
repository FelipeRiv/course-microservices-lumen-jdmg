<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Services\AuthorService;
use App\Traits\ConsumeExternalService;

class AuthorController extends Controller
{

    use ApiResponser;
    use ConsumeExternalService;

    /**
     * The service to consume the author service
     * @var AuthorService
     */
    public $authorService;

    /**
     * Creates a new controller instance.
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Retrieve and show all the authors
     * @return Illuminate\Http\Response
     */
    public function index(){

        $authors = $this->authorService->obtainAuthors();

        return $this->successResponse($authors, Response::HTTP_OK);
        
    }

    /**
     * Create an instance of author
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request){

        $data = $request->all();

        $authorCreated = $this->authorService->createAuthor($data);

        return $this->successResponse($authorCreated, Response::HTTP_CREATED);
    }

    /**
     * Show an instance of author 
     * @return Illuminate\Http\Response 
     */
    public function show($author){

        $authorRequest = $this->authorService->obtainAuthor($author);

        return $this->successResponse($authorRequest);
    }

    /**
     * Updates an instance of author
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $author){

        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));

        // $data = $request->all();

        // $updateResponse = $this->authorService->updateAuthor($data, $author);

        // return $this->successResponse($updateResponse);
        
    }


    
    /**
     * Removes an instance of author
     * @return Illuminate\Http\Response 
     */
    public function destroy($author){

        return $this->successResponse($this->authorService->deleteAuthor($author));
    }

}
