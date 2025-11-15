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
        public function submitAttendance()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->fail("Invalid or missing JSON", 400);
        }

        // required fields
        $rules = [
            'student_id' => 'required|numeric',
            'section_id' => 'required|numeric',
            'date'       => 'required',
            'status'     => 'required',
            'remarks'    => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model = new \App\Models\AttendanceModel();

        // insert entry
        $inserted = $model->insert($data);

        if (!$inserted) {
            return $this->fail("Failed to record attendance", 500);
        }

        return $this->respondCreated([
            'message' => 'Attendance submitted successfully',
            'attendance_id' => $inserted
        ]);
    }

}
