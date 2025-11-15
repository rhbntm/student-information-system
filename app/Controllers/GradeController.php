<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GradeModel;

class GradeController extends ResourceController
{
    protected $modelName = 'App\Models\GradeModel';
    protected $format    = 'json';

    // GET /api/grades
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /api/grades/{id}
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) return $this->failNotFound("Grade record not found");
        return $this->respond($data);
    }

    // POST /api/grades
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->fail("Failed to create grade record");
    }

    // PUT /api/grades/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        }
        return $this->fail("Failed to update grade record");
    }

    // DELETE /api/grades/{id}
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Record deleted']);
        }
        return $this->failNotFound("Grade record not found or could not be deleted");
    }

    public function studentGPA($student_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('academic_records');
        $builder->selectAvg('gpa', 'average_gpa');
        $builder->where('student_id', $student_id);
        $query = $builder->get();
        $result = $query->getRow();

        // ✅ Detect missing or null data
        if (!$result || $result->average_gpa === null) {
            return $this->failNotFound("No GPA data found for student ID {$student_id}");
        }

        return $this->respond([
            'student_id'  => $student_id,
            'average_gpa' => round($result->average_gpa, 2)
        ]);
    }

    public function submitGrades()
{
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->fail("Invalid or missing JSON", 400);
        }

        // Required fields
        $rules = [
            'student_id' => 'required|numeric',
            'course_id'  => 'required|numeric',
            'grade'      => 'required',
            'gpa'        => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model = new \App\Models\GradeModel();

        // Insert new grade
        $inserted = $model->insert($data);

        if (!$inserted) {
            return $this->fail("Failed to submit grade", 500);
        }

        return $this->respondCreated([
            'message'   => 'Grade submitted successfully',
            'record_id' => $inserted
        ]);
    }

    }
