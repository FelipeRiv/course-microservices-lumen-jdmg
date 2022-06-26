<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
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
     * Return author list
     * @return list of authors
     */
    public function index(){

        $authors = Author::all();

        return $this->successResponse($authors);
        // return $authors;
    }

    /**
     * Create an instance of author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all() );

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Return a specific author
     * @return Illuminate\Http\Response
     */
    public function show($author){
         $author = Author::findOrFail($author); // model not found exception

        return $this->successResponse($author);
    }

    /**
     * Update a specific author
     * @return Illuminate\Http\Response
     */
    public function edit(){

    }

    /**
     * Update the information of an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        // checks if the author exists
        $author = Author::findOrFail($author);

        // fill the author with the request info if that author exists
        $author->fill($request->all());

        // if the author is clean and therefore it has not change, we wont do any action in the DB
        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY); // 422 code
        }

        // if the author values request has changed then we will update save the record
        $author->save();
        return $this->successResponse($author);
    }


    /**
     * Removes an existing author 
     * @return Illuminate\Http\Response
     */
    public function destroy(Request $request, $author){
        $author = Author::findOrFail($author);

        $author->delete();

        return $this->successResponse($author);
    }
}
