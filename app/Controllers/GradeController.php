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
}
