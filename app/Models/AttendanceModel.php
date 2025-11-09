<?php
namespace App\Models;
use CodeIgniter\Model;

class AttendanceModel extends Model {
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    protected $allowedFields = ['student_id', 'section_id', 'date', 'status', 'remarks'];
}
    