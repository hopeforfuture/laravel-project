<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Subject;
use Session;
use Illuminate\Validation\Rule;
use Validator;

class StudentController extends Controller {

    public function getAllSubjects() {
        $subjects = Subject::where('status', '=', '1')->orderBy('created', 'desc')->get();
        return $subjects;
    }

    public function getAllClasses() {
        $classes = array(1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII');
        return $classes;
    }

    public function index(Request $request) {
        $subjects = $this->getAllSubjects();
        $subjectarr = array();
        $studentsarr = array();
        $clslist = $this->getAllClasses();
        if (!empty($subjects)) {
            foreach ($subjects as $subject) {
                $sub_id = $subject->id;
                $sub_code = $subject->code;

                $subjectarr[$sub_id] = $sub_code;
            }
        }
        $students = Student::where('status', '=', '1')->orderBy('id', 'DESC')->paginate(10);
        return view('student.index', ['students' => $students, 'subjects' => $subjectarr, 'classes' => $clslist])
                        ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create() {
        $subjects = $this->getAllSubjects();
        $classes = $this->getAllClasses();
        return view('student.add', ['subjects' => $subjects, 'classes' => $classes]);
    }

    public function insert(Request $request) {
        $postdata = $request->all();
        $len = count($postdata['name']);
        $unique_str_arr = array();
        $fav_sub_num_unique = explode(",", $postdata['fav_sub_num']);
        $fav_sub_num = array();
        if (!empty($fav_sub_num_unique)) {
            foreach ($fav_sub_num_unique as $unique_str) {
                $unique_str_arr = explode("@", $unique_str);
                $fav_sub_num[] = $unique_str_arr[1];
            }
        }

        $sub_len = current($fav_sub_num);
        $sub_arr = array();
        $start_sub_index = 0;
        $fav_sub_arr = $postdata['fav_subjects'];

        for ($j = 0; $j < $len; $j++) {

            $sub_arr = array_splice($fav_sub_arr, $start_sub_index, $sub_len);
            $sub_std = implode(",", $sub_arr);
            $std = new Student;

            $std->name = trim($postdata['name'][$j]);
            $std->email = trim($postdata['email'][$j]);
            $std->contact = trim($postdata['contact'][$j]);
            $std->gender = trim($postdata['gender'][$j]);
            $std->roll_no = trim($postdata['roll_no'][$j]);
            $std->student_class = trim($postdata['student_class'][$j]);
            $std->section = trim($postdata['section'][$j]);
            $std->fav_subjects = $sub_std;
            $std->save();

            $sub_len = next($fav_sub_num);
            $sub_std = '';
            $sub_arr = array();
        }

        Session::flash('success_msg', 'Student Added successfully.');

        return redirect()->route('students.index');
    }

    public function view($id) {
        $student = Student::find($id);
        $subjects = $this->getAllSubjects();
        $subjectarr = array();
        if (!empty($subjects)) {
            foreach ($subjects as $subject) {
                $sub_id = $subject->id;
                $sub_code = $subject->code;

                $subjectarr[$sub_id] = $sub_code;
            }
        }
        return view('student.view', ['student' => $student, 'subjects' => $subjectarr]);
    }

    public function edit($id) {
        $classes = $this->getAllClasses();
        $student = Student::find($id);
        $subjects = $this->getAllSubjects();
        return view('student.edit', ['std' => $student, 'classes' => $classes, 'subjects' => $subjects]);
    }

    public function update($id, Request $request) {

        //get post data
        $postdata = $request->all();
        $postdata['fav_subjects'] = implode(",", $postdata['fav_subjects']);

        //update post data
        Student::find($id)->update($postdata);

        //store status message
        Session::flash('success_msg', 'Student updated successfully!');
        return redirect()->route('students.index');
    }

    public function remove($id) {
        $student = Student::find($id);
        $student->status = '0';
        $student->save();

        //store status message
        Session::flash('success_msg', 'Student deleted successfully!');
        return redirect()->route('students.index');
    }

}
