<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class CourseController extends ResourceController
{
    protected $modelName = 'App\Models\CourseModel';
    protected $format    = 'json';

    // GET /courses
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /courses/{id}
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Course not found');
        }
        return $this->respond($data);
    }

    // POST /courses
    public function create()
    {
        $input = $this->request->getJSON(true);

        if (!$this->validate([
            'department_id' => 'required|integer',
            'course_code'   => 'required',
            'title'         => 'required',
            'credit_hours'  => 'required|integer'
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->model->insert($input);
        return $this->respondCreated(['message' => 'Course added successfully']);
    }

    // PUT /courses/{id}
    public function update($id = null)
    {
        $input = $this->request->getJSON(true);
        $course = $this->model->find($id);

        if (!$course) {
            return $this->failNotFound('Course not found');
        }

        $this->model->update($id, $input);
        return $this->respond(['message' => 'Course updated successfully']);
    }

    // DELETE /courses/{id}
    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Course not found');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Course deleted successfully']);
    }
}
