<?php 

namespace App\Services;

use App\Traits\ConsumeExternalService;

/**
 * Consume an external service using trait ConsumeExternalService
 */
class AuthorService
{
    use ConsumeExternalService;

    /**
     * The base uri to be used to consume the authros service
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
        // Config/services.php/authors.base_uri  -> archivo de consiguracion de los uri de los servicios a consumir y los secret para autentificar todos establecidos en env() desde config/services AND si el secret esta estabblecido enviarlo como headers en ConsumeExternalService trait

        $this->baseUri = config('services.authors.base_uri');
        $this->secret = config('services.authors.secret');
        
    }

    /**
     * Get full list of authores from the authors service
     * @return string 
     */
    public function obtainAuthors(){

        return $this->performRequest('GET', '/authors');
    }

    /**
     * Create an instance of author using the authors service
     * @param data form
     * @return string
     */
    public function createAuthor($data){
        return $this->performRequest('POST', '/authors', $data);
    }

    /**
     * Get an author using the authors service
     * @param data form
     * @return string
     */
    public function obtainAuthor ($author){
        // dd($author);
        return $this->performRequest('GET', "/authors/{$author}");
    }

    public function editAuthor($data, $author){

        return $this->performRequest('PUT', "/authors/{$author}", $data);
    }
    
    public function deleteAuthor($author){

        return $this->performRequest('DELETE', "authors/{$author}");
    }
}
