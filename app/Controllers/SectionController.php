<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class SectionController extends ResourceController
{
    protected $modelName = 'App\Models\SectionModel';
    protected $format = 'json';

    public function index() {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null) {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Section not found');
    }

    public function create() {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Section added successfully']);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null) {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Section updated']);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null) {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Section deleted']);
        }
        return $this->failNotFound('Section not found');
    }
}
