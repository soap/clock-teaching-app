<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * แสดงหน้านักเรียน
     */
    public function index()
    {
        return Inertia::render('Student');
    }
}
