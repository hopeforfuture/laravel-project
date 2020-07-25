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
        <div class="panel panel-default">
            <div class="panel-heading">
                Add  New Student <a href="{{ route('students.index') }}" class="label label-primary pull-right">Back</a>
				
				
            </div>
            <div class="panel-body" style="overflow:scroll;">
                <form id="frmstudent"  action="{{ route('students.insert') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
				  <div class="tr_clone" id="addon">  
						<div class="form-group row" >
						
						  <div class="col-xs-2">
							<label for="ex1">Name</label>
							<input required class="form-control stdname"  type="text" name="name[]">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex2">Email Adress</label>
							<input required class="form-control stdemail" type="email" name="email[]">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Contact No</label>
							<input required class="form-control stdcontact" type="text" name="contact[]">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Gender</label>
							<select required class="form-control stdgend" name="gender[]">
								<option value="">---Select Gender---</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Roll No</label>
							<input required class="form-control roll_no" type="number" name="roll_no[]">
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Class</label>
							<select required class="form-control cls" name="student_class[]">
								<option value="">---Select Class---</option>
								@foreach ($classes as $key=>$val)
								<option value="{{$key}}">{{$val}}</option>
								@endforeach
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Section</label>
							<select required class="form-control stdsec" name="section[]">
								<option value="">---Select Section---</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="B">C</option>
								<option value="B">D</option>
								<option value="B">E</option>
							</select>
						  </div>
						  
						  <div class="col-xs-2">
							<label for="ex3">Favourite Subjects</label>
							<select required multiple class="form-control fs" name="fav_subjects[]">
								<option value="0">---Select Favourite Subject---</option>
								@foreach($subjects as $subject)
								<option value="{{$subject->id}}">{{$subject->code}}</option>
								@endforeach
							</select>
						  </div>
						 
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2" style="float:right;margin-top:-42px;">
							
							<a href="Javascript:void(0)" class="plus">
								<img src='{{ asset("img/plus.jpg")}}' width="40" height="30" />
							</a>
							<a href="Javascript:void(0)" class="minus" >
								<img  src='{{ asset("img/remove.png")}}' width="40" height="30" />
							</a>
						</div>
						  
				 </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="fav_sub_num" id="fav_sub_num" />
                            <input type="submit" class="btn btn-default" value="Save" onclick="Javascript: return formvalidate();" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('common.scripts')
<script>
 $.ajaxSetup({

	headers: {

		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}

});
$(document).ready(function(){
	var len = $(".panel-body").find('.fs').length;
	var rand = Math.floor(Math.random()*1000);
	var fav_sub_id = "fav_"+rand;
	$(".panel-body").find('.fs').attr('id', fav_sub_id);
	var fav_sub = new Array();
	var str_to_be_pushed = '';
	var str_to_be_removed = '';
	
	$("body").on("click", ".plus", function(){
		var $tr = $(this).closest('.tr_clone');
		var $clone = $tr.clone();         
		$clone.find('input').val(''); 
		$clone.find('select').val('');
		$tr.after($clone);
		rand = Math.floor(Math.random()*1000);
		fav_sub_id = "fav_"+rand;
		$clone.find('.fs').attr('id', fav_sub_id);
	});
	
	$("body").on("click", ".minus", function() {
		var div_count = $('div.tr_clone').length;
		if(div_count > 1)
		{
			var fav_sub_id_remove = "#"+$(this).closest('.tr_clone').find('.fs').attr('id');
			var selected_len = $(fav_sub_id_remove + ' option:selected').length;
			str_to_be_removed = $(this).closest('.tr_clone').find('.fs').attr('id') + "@" + selected_len;
			for( var i = 0; i < fav_sub.length; i++)
			{ 
			   if ( fav_sub[i] == str_to_be_removed) 
			   {
				 fav_sub.splice(i, 1);
				 break;
			   }
			}
			$("#fav_sub_num").val(fav_sub.join(','));
			$(this).closest('.tr_clone').remove(); 
		}       
	});
	
	$("body").on("change", ".fs", function(){
		fav_sub = [];
		$(".fs").each(function(){
			var ddn_id = "#"+$(this).attr('id');
			var selected_len = $(ddn_id + ' option:selected').length;
			str_to_be_pushed = $(this).attr('id') + "@" + selected_len;
			if(selected_len > 0)
			{
				fav_sub.push(str_to_be_pushed);
			}
			
		});
		$("#fav_sub_num").val(fav_sub.join(','));
	});
});


function ValidateEmail(str)
{
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(str.match(mailformat))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function formvalidate()
{
	var flag = true;
	var name = '';
	var email = '';
	err_email_invalid = '';
	var contact = '';
	var gender = '';
	var roll_no_val = '';
	var class_val = '';
	var sec = '';
	var sub = '';
	var std_roll_arr = Array();
	var std_roll_str = '';
	var alreadySeen = [];
	
	var err_name = '';
	var err_email = '';
	var err_contact = '';
	var err_gender = '';
	var err_roll = '';
	var err_roll_duplicate = '';
	var err_roll_use = '';
	var err_class = '';
	var err_sec = '';
	var err_sub = '';
	var err_msg = '';
	var separator = '<br/>';
	
	$(".stdname").each(function(){
		name = $.trim($(this).val());
		if(name == '')
		{
			err_name = 'One or more name field is blank.' + separator;
		}
	});
	
	$(".stdemail").each(function(){
		email = $.trim($(this).val());
		if(email == '')
		{
			err_email = 'One or more email field is blank.' + separator;
		}
		else if(email.length > 0)
		{
			if(ValidateEmail(email) == false)
			{
				err_email_invalid = 'One or more email field is invalid.' + separator;
			}
		}
	});
	
	$(".stdcontact").each(function(){
		contact = $.trim($(this).val());
		if(contact == '')
		{
			err_contact = 'One or more contact field is blank.' + separator;
		}
	});
	
	$(".stdgend").each(function(){
		gender = $.trim($(this).val());
		if(gender == '')
		{
			err_gender = 'One or more gender field is blank.' + separator;
		}
	});
	
	$(".roll_no").each(function(){
		roll_no_val = $(this).val();
		if(roll_no_val == '')
		{
			err_roll = 'One or more roll no field is blank.' + separator;
		}
	});
	
	$(".cls").each(function(){
		class_val = $(this).val();
		if(class_val == '')
		{
			err_class = 'One or more class field is blank.' + separator;
		}
	});
	
	$(".stdsec").each(function(){
		sec = $(this).val();
		if(sec == '')
		{
			err_sec = 'One or more section field is blank.' + separator;
		}
	});
	
	$(".fs").each(function(){
		sub = $(this).val();
		if(sub == '')
		{
			err_sub = 'One or more subject field is blank.' + separator;
		}
	});
	
	$(".roll_no").each(function(){
		roll_no_val = $(this).val();
		class_val = $(this).closest('.tr_clone').find('.cls').val();
		if(roll_no_val != '' && class_val != '')
		{
			std_roll_arr.push(roll_no_val+"#"+class_val);
		}
		
	});
	
	for(var j = 0; j < std_roll_arr.length; j++)
	{
		var roll = std_roll_arr[j];
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
	
	std_roll_str = std_roll_arr.join(',');
	
	if(std_roll_str.length > 0)
	{
		$.ajax({
			type: "post",
			async:false,
			url: '/students/roll/check',
			data:{roll_str: std_roll_str},
			success:function(response)
			{
				if(response == 'failed')
				{
					flag = false;
					err_roll_use = 'One or more roll no is in use.';
				}
			}
		});
	}
	
	err_msg = err_name + err_email + err_email_invalid + err_contact + err_gender + err_roll + err_roll_duplicate + err_roll_use + err_class + err_sec + err_sub;
	
	if(err_msg == '')
	{
		return true;
	}
	else
	{
		$(".modal-body").html(err_msg);
		$("#myModal").modal();
		return false;
	}
}

</script>
@endsection