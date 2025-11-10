<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\StudentBalanceModel;

class StudentBalanceController extends ResourceController
{
    protected $modelName = 'App\Models\StudentBalanceModel';
    protected $format = 'json';

    // GET /api/balances
    public function index()
    {
        $model = new StudentBalanceModel();
        return $this->respond($model->findAll());
    }

    // GET /api/balances/{id}
    public function show($id = null)
    {
        $model = new StudentBalanceModel();
        $data = $model->find($id);
        if (!$data) {
            return $this->failNotFound("Balance record not found");
        }
        return $this->respond($data);
    }

    // GET /api/balances/student/{student_id}
    public function getByStudent($student_id = null)
    {
        $model = new StudentBalanceModel();
        $data = $model->where('student_id', $student_id)->first();
        if (!$data) {
            return $this->failNotFound("No balance record found for student ID {$student_id}");
        }
        return $this->respond($data);
    }

    // POST /api/balances
    public function create()
    {
        $model = new StudentBalanceModel();
        $data = $this->request->getJSON(true);
        $model->insert($data);
        return $this->respondCreated($data);
    }

    // PUT /api/balances/{id}
    public function update($id = null)
    {
        $model = new StudentBalanceModel();
        $data = $this->request->getJSON(true);
        if (!$model->find($id)) {
            return $this->failNotFound("Balance not found");
        }
        $model->update($id, $data);
        return $this->respond(['message' => 'Balance updated', 'data' => $data]);
    }

    // DELETE /api/balances/{id}
    public function delete($id = null)
    {
        $model = new StudentBalanceModel();
        if (!$model->find($id)) {
            return $this->failNotFound("Balance not found");
        }
        $model->delete($id);
        return $this->respondDeleted(['message' => 'Balance deleted']);
    }
}
