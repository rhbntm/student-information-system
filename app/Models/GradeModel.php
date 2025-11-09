<?php
namespace App\Models;
use CodeIgniter\Model;

class GradeModel extends Model {
    protected $table = 'academic_records';
    protected $primaryKey = 'record_id';
    protected $allowedFields = ['student_id', 'course_id', 'grade', 'gpa'];
}
