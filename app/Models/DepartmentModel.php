<?php
namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'department_id';
    protected $allowedFields = ['name', 'contact_email', 'office_location'];
}
