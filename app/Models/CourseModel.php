<?php
namespace App\Models;
use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $allowedFields = [
        'department_id',
        'course_code',
        'title',
        'credit_hours'
    ];
}
