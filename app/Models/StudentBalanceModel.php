<?php
namespace App\Models;

use CodeIgniter\Model;

class StudentBalanceModel extends Model
{
    protected $table = 'student_balance';
    protected $primaryKey = 'balance_id';
    protected $allowedFields = [
        'student_id', 'program_id',
        'total_due', 'total_paid', 'outstanding_balance'
    ];
    protected $useTimestamps = false;
}
