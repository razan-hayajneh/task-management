<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeGroupsResource;
use App\Models\Employee;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $nationalStudentNumber = Student::where('system_id', 1)->whereIn('student_status_id', [1,2])->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        $internationalStudentNumber = Student::where('system_id', 2)->whereIn('student_status_id', [1,2])->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        $maleStudentNumber = Student::where('gender_id', 2)->where('gender_id', 2)->whereIn('student_status_id', [1,2])->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        // dd($maleStudentNumber);
        $femaleStudentNumber = Student::where('gender_id', 1)->whereIn('student_status_id', [1,2])->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        $teacherNumber = User::where('user_status_id', 1)->whereHas('groups', function ($q) {
            $q->where('group_id', 3);
        })->count();
        $deactivateTeacherNumber = User::where('user_status_id', 0)->whereHas('groups', function ($q) {
            $q->where('group_id', 3);
        })->count();
        $activeEmployeeNumber = Employee::with('user')->join('users', 'employees.user_id', '=', 'users.id')->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        $deactivateEmployeeNumber = Employee::with('user')->whereHas('user', function ($q) {
            $q->where('user_status_id', 2);
        })->count();
        $allEmployeeGroups =[];
        // $allEmployeeGroups = Employee::select(DB::raw('count(*) as number'), 'job_title_id')->whereHas('user', function ($q) {
        //     $q->where('user_status_id', 1);
        // })->groupby('job_title_id')->get();
        $employeeGroups = EmployeeGroupsResource::collection($allEmployeeGroups);
        $guardianNumber = Guardian::where('is_primary', 1)->whereHas('user', function ($q) {
            $q->where('user_status_id', 1);
        })->count();
        $allGroups = Auth::user()->groups()->pluck('name')->toArray();
        return Inertia::render('Admin/Home')->with([
            'userGroups' => $allGroups,
            'teacherNumber' => $teacherNumber, 'deactivateTeacherNumber' => $deactivateTeacherNumber,
            'activeEmployeeNumber' => $activeEmployeeNumber,
            'deactivateEmployeeNumber' => $deactivateEmployeeNumber,
            'employeeGroups' => $employeeGroups, 'guardianNumber' => $guardianNumber,
            'nationalStudentNumber' => $nationalStudentNumber, 'internationalStudentNumber' => $internationalStudentNumber,
            'femaleStudentNumber' => $femaleStudentNumber, 'maleStudentNumber' => $maleStudentNumber
        ]);
    }
}
