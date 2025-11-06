<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class AttendanceController extends ResourceController
{
    protected $modelName = 'App\Models\AttendanceModel';
    protected $format = 'json';

    public function index() {
        $data = $this->model->findAll();
        return $this->respond($data);
    }

    public function show($id = null) {
        $record = $this->model->find($id);
        return $record ? $this->respond($record) : $this->failNotFound('Attendance record not found');
    }

    public function create() {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Attendance record created successfully']);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null) {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Attendance record updated']);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null) {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Attendance record deleted']);
        }
        return $this->failNotFound('Record not found');
    }
}
