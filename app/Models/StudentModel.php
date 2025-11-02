<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'student_id';
    protected $allowedFields = [
        'first_name', 
        'last_name', 
        'birthdate', 
        'gender', 
        'email', 
        'phone_no', 
        'address', 
        'program_id'
    ];
}
