<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class DepartmentController extends ResourceController
{
    protected $modelName = 'App\Models\DepartmentModel';
    protected $format = 'json';

    // GET /departments
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // Optional: GET /departments/{id}
    public function show($id = null)
    {
        $department = $this->model->find($id);
        if (!$department) {
            return $this->failNotFound('Department not found');
        }
        return $this->respond($department);
    }
}
