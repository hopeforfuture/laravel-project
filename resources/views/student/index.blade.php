@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
    <!-- Posts list -->
    @if(!empty($students))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Students List </h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('students.add') }}"> Add New</a>
					<a class="btn btn-primary" href="{{ route('subjects.index') }}"> Subjects List</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
						<th>Serial No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
						<th>Class</th>
                        <th>Roll No</th>
                        <th>Favourite Subjects</th>
                        <th>Created</th>
                        <th>Action</th>
                    </thead>
    
                    <!-- Table Body -->
                    <tbody>
                    @foreach($students as $student)
						@php
							$fav_sub_str = '';
							$fav_sub = explode(",",$student->fav_subjects);
							foreach($fav_sub as $key=>$sub)
							{
								$fav_sub_str.=$subjects[$sub].",";
							}
							$fav_sub_str = rtrim($fav_sub_str, ",");
							$class = $classes[$student->student_class];
						@endphp
                        <tr>
							<td class="table-text">
								<div>{{++$i}}</div>
							</td>
                            <td class="table-text">
                                <div>{{$student->name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$student->email}}</div>
                            </td>
							<td class="table-text">
                                <div>{{$student->contact}}</div>
                            </td>
							<td class="table-text">
                                <div>{{$class}}</div>
                            </td>
							<td class="table-text">
                                <div>{{$student->roll_no}}</div>
                            </td>
							<td class="table-text">
                                <div>{{$fav_sub_str}}</div>
                            </td>
							
                            <td class="table-text">
                                <div>
									@php
										echo date('F j,Y H:i:s', strtotime($student->created));
									@endphp 
								</div>
                            </td>
                            <td>
								<a href="{{ route('students.edit', $student->id) }}" class="label label-warning">Edit</a>
								<a target="_blank" href="{{ route('students.view', $student->id) }}" class="label label-info">View</a>
                                <a href="{{ route('students.delete', $student->id) }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a>
                            </td>
                        </tr>
						@php
							$fav_sub_str = '';
						@endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
		 <nav>
			<ul class="pagination justify-content-end">
				 {{$students->links('vendor.pagination.bootstrap-4')}}
			 </ul>
		</nav>
		@else
			No record found
    @endif
    </div>
</div>
@endsection