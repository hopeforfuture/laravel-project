@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach()
            </div>
        @endif
		
		@php
			$fav_sub_std = explode(",", $std->fav_subjects);
		@endphp
		
		
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Student <a href="{{ route('students.index') }}" class="label label-primary pull-right">Back</a>
				
				
            </div>
            <div class="panel-body" style="overflow:scroll;">
                <form id="frmstudent" onsubmit="formvalidate();return false" action="{{ route('students.update', $std->id) }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
				  <div class="tr_clone" id="addon">  
						<div class="form-group row" >
						
						  <div class="col-xs-2">
							<label for="ex1">Name</label>
							<input required class="form-control"  type="text" name="name" value="{{$std->name}}">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex2">Email Adress</label>
							<input required class="form-control" type="email" name="email" value="{{$std->email}}">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Contact No</label>
							<input required class="form-control" type="text" name="contact" value="{{$std->contact}}">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Gender</label>
							<select required class="form-control" name="gender">
								<option value="">---Select Gender---</option>
								<option @if($std->gender == 'M') selected @endif value="M">Male</option>
								<option @if($std->gender == 'F') selected @endif value="F">Female</option>
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Roll No</label>
							<input required class="form-control roll_no" type="number" name="roll_no" value="{{$std->roll_no}}">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Class</label>
							<select required class="form-control" name="student_class">
								<option value="">---Select Class---</option>
								@foreach ($classes as $key=>$val)
								<option @if($std->student_class == $key) selected @endif value="{{$key}}">{{$val}}</option>
								@endforeach
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Section</label>
							<select required class="form-control" name="section">
								<option value="">---Select Section---</option>
								<option @if($std->section == 'A') selected @endif value="A">A</option>
								<option @if($std->section == 'B') selected @endif value="B">B</option>
								<option @if($std->section == 'C') selected @endif value="B">C</option>
								<option @if($std->section == 'D') selected @endif value="B">D</option>
								<option @if($std->section == 'E') selected @endif value="B">E</option>
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Favourite Subjects</label>
							<select required multiple class="form-control fs" name="fav_subjects[]">
								<option value="0">---Select Favourite Subject---</option>
								@foreach($subjects as $subject)
								<option @if(in_array($subject->id, $fav_sub_std)) selected @endif value="{{$subject->id}}">{{$subject->code}}</option>
								@endforeach
							</select>
						  </div>
						 
						</div>
						
						  
				 </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-default" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
 $.ajaxSetup({

	headers: {

		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}

});

/*function formvalidate()
{
	var flag = true;
	var fav_roll_arr = Array();
	var fav_roll_str = '';
	var roll_no_val = '';
	var alreadySeen = [];
	var err_roll_duplicate = '';
	var err_roll_use = '';
	var err_msg = '';
	var separator = '<br/>';
	
	$(".roll_no").each(function(){
		roll_no_val = $(this).val();
		fav_roll_arr.push(roll_no_val);
	});
	
	for(var j = 0; j < fav_roll_arr.length; j++)
	{
		var roll = fav_roll_arr[j];
		if(alreadySeen[roll])
		{
			flag = false;
			err_roll_duplicate = 'Duplicate roll no entered.' + separator;
			break;
		}
		else
		{
			alreadySeen[roll] = true;
		}
	}
	
	fav_roll_str = fav_roll_arr.join(',');
	
	$.ajax({
		type: "post",
		async:false,
		url: '/students/roll/check',
		data:{roll_str: fav_roll_str},
		success:function(len)
		{
			if(len > 0)
			{
				flag = false;
				err_roll_use = 'One or more roll no is in use.';
			}
		}
	});
	
	err_msg = err_roll_duplicate + err_roll_use;
	
	if(err_msg == '')
	{
		$("#frmstudent").submit();
	}
	else
	{
		
		$(".modal-body").html(err_msg);
		$("#myModal").modal();
	}
}*/

</script>
@endsection