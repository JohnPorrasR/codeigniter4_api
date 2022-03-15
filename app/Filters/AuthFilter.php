<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $request->getHeader("Authorization");
        $token = null;
		
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
		
        if(is_null($token) || empty($token)) {
            $response = service('response');
            $response->setBody('Acceso denegado');
            $response->setStatusCode(401);
            return $response;
        }
 
        try {

			$decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $ex) {
            $response = service('response');
            $response->setBody('Access denied');
            $response->setStatusCode(401);
            return $response;
        }
    }
	
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
