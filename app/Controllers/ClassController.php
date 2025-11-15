<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SectionEnrollmentModel;
use App\Models\StudentModel;

class ClassController extends ResourceController
{
    protected $format = 'json';

    // GET /class/students/{section_id}
    public function getClassStudents($section_id)
    {
        $enrollModel = new SectionEnrollmentModel();
        $studentModel = new StudentModel();

        // Get all student IDs from the enrollment table
        $enrolled = $enrollModel
            ->where('section_id', $section_id)
            ->findAll();

        if (!$enrolled) {
            return $this->respond(['message' => 'No students enrolled'], 404);
        }

        // Build final student list
        $students = [];
        foreach ($enrolled as $en) {
            $student = $studentModel->find($en['student_id']);
            if ($student) {
                $students[] = $student;
            }
        }

        return $this->respond($students);
    }
}
