@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>View Student Details</h2>
        </div>
        <div class="pull-right">
            <a href="{{ route('students.index') }}" class="label label-primary pull-right"> Back</a>
        </div>
    </div>
</div>
@php
if($student->gender == 'M')
{
	$gender = 'Male';
}
else
{
	$gender = 'Female';
}
$fav_sub_str = '';
$fav_sub_arr = explode(",", $student->fav_subjects);
foreach($fav_sub_arr as $fs)
{
	$fav_sub_str.=$subjects[$fs].",";
}
$fav_sub_str = rtrim($fav_sub_str, ",");
@endphp
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $student->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $student->email }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Contact No:</strong>
            {{ $student->contact }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Gender:</strong>
            {{ $gender }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roll No:</strong>
            {{ $student->roll_no }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Class:</strong>
            {{ $student->student_class }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Section:</strong>
            {{ $student->section }}
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Favourite Subjects:</strong>
            {{ $fav_sub_str }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Published On:</strong>
            {{ $student->created }}
        </div>
    </div>
	
	
</div>
@endsection