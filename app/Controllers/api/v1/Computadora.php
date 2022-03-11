<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Computadora extends ResourceController
{
    private $user;

	public function __construct()
	{
        $this->user = new UserModel();
	}

    public function index()
    {
		$data = $this->user->findAll();
        return $this->respond($data);
    }
	
    public function show($id = null)
    {
        //
    }
	
    public function new()
    {
        //
    }
	
    public function create()
    {
        //
    }
	
    public function edit($id = null)
    {
        //
    }
	
    public function update($id = null)
    {
        //
    }
	
    public function delete($id = null)
    {
        //
    }
}
