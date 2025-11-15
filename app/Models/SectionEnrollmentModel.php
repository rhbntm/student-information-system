<?php
namespace App\Models;

use CodeIgniter\Model;

class SectionEnrollmentModel extends Model
{
    protected $table = 'section_enrollment';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'section_id',
        'student_id'
    ];
}
