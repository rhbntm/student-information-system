<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class StudentController extends ResourceController
{
    protected $modelName = 'App\Models\StudentModel';
    protected $format = 'json';

    public function index()
    {   
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Student not found');
    }

    public function create()
    {
        $input = $this->request->getJSON(true);

        if ($this->model->insert($input) === false) {
            return $this->fail([
                'error' => 'Failed to add student',
                'db_errors' => $this->model->errors()
            ]);
        }

        return $this->respondCreated(['message' => 'Student added']);
    }


    public function update($id = null)
    {
        $input = $this->request->getJSON(true);
        if ($this->model->update($id, $input))
            return $this->respond(['message' => 'Student updated']);
        return $this->fail('Failed to update student');
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id))
            return $this->respondDeleted(['message' => 'Student deleted']);
        return $this->failNotFound('Student not found');
    }
}
