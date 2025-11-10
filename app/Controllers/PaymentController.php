<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PaymentModel;
use App\Models\StudentBalanceModel;

class PaymentController extends ResourceController
{
    protected $modelName = 'App\Models\PaymentModel';
    protected $format    = 'json';

    // List all payments
    public function index()
    {
        $model = new PaymentModel();
        return $this->respond($model->findAll());
    }

    // Add a new payment
    public function create()
    {
        $paymentModel = new PaymentModel();
        $balanceModel = new StudentBalanceModel();

        $data = $this->request->getJSON(true);
        $student_id = $data['student_id'];

        // 🔍 Find the balance for this student
        $balance = $balanceModel->where('student_id', $student_id)->first();

        if (!$balance) {
            return $this->failNotFound("No balance record found for student ID {$student_id}");
        }

        // ✅ Auto-link the balance_id
        $data['balance_id'] = $balance['balance_id'];

        // Insert new payment
        $paymentModel->insert($data);

        // 💰 Update totals
        $newPaid = $balance['total_paid'] + $data['amount'];
        $newOutstanding = $balance['total_due'] - $newPaid;

        $balanceModel->update($balance['balance_id'], [
            'total_paid' => $newPaid,
            'outstanding_balance' => $newOutstanding
        ]);

        return $this->respondCreated([
            'message' => 'Payment recorded and balance updated successfully',
            'data' => $data
        ]);
    }


    // View single payment
    public function show($id = null)
    {
        $model = new PaymentModel();
        $data = $model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound("Payment not found");
    }

    // Update payment record
    public function update($id = null)
    {
        $model = new PaymentModel();
        $data = $this->request->getJSON(true);

        if (!$model->find($id)) {
            return $this->failNotFound("Payment not found");
        }

        $model->update($id, $data);
        return $this->respond(['message' => 'Payment updated', 'data' => $data]);
    }

    // Delete payment
    public function delete($id = null)
    {
        $model = new PaymentModel();
        if (!$model->find($id)) {
            return $this->failNotFound("Payment not found");
        }

        $model->delete($id);
        return $this->respondDeleted(['message' => 'Payment deleted']);
    }
}
