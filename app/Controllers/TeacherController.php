<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TeacherModel;
use App\Models\SectionModel;

class TeacherController extends ResourceController
{
    protected $format = 'json';

    // GET /teacher/classes/{teacher_id}
    public function getTeacherClasses($teacher_id)
    {
        $sectionModel = new SectionModel();

        // Fetch sections where teacher_id matches
        $classes = $sectionModel
            ->where('teacher_id', $teacher_id)
            ->findAll();

        if (!$classes) {
            return $this->respond(['message' => 'No classes found'], 404);
        }

        return $this->respond($classes);
    }
}
