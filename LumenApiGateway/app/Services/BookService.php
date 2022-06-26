<?php 

namespace App\Services;

use App\Traits\ConsumeExternalService;

/**
 * Consume an external service using trait ConsumeExternalService
 */
class BookService
{
    use ConsumeExternalService;

       /**
     * The base uri to be used to consume the books service
     * @var string
     */
    public $baseUri;
      /**
     * the secret to be used to consume the authros service
     * @var string 
     */
    public $secret;

    public function __construct()
    {
        // Config/services.php/books.base_uri  -> archivo de configuracion de los uri de los servicios a consumir y los secret para autentificar todos establecidos en env() desde config/services AND si el secret esta estabblecido enviarlo como headers en ConsumeExternalService trait

        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
        
    }


    public function obtaingBooks(){
        return $this->performRequest('GET', 'books');
    }

    public function createBook($data){
        return $this->performRequest('POST', '/books', $data);
    }

    public function obtaingBook($book){
        return $this->performRequest('GET', "/books/{$book}");
    }

    public function editBook($data, $book){
        return $this->performRequest('PUT', "/books/{$book}", $data);
    }

    public function deleteBook($book){
        return $this->performRequest('DELETE', "/books/{$book}");
    }

}
