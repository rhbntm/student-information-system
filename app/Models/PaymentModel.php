<?php
namespace App\Models;
use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payment';
    protected $primaryKey       = 'payment_id';
    protected $allowedFields    = [
        'student_id', 'balance_id', 'course_id',
        'amount', 'payment_date', 'payment_method', 'reference_number'
    ];
    protected $useTimestamps    = false;
}
