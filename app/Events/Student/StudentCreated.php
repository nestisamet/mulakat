<?php

namespace App\Events\Student;


use Illuminate\Queue\SerializesModels;

class StudentCreated
{
    use SerializesModels;

    public $student;

    /**
     * StudentCreated constructor.
     * @param $student
     */
    public function __construct($student)
    {
        $this->student = $student;
    }
}