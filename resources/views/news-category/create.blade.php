@extends('layouts.master')

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
                Add New Category <a href="{{ route('newscategory.index') }}" class="label label-primary pull-right">Back</a>
            </div>
            <div class="panel-body">
                <form action="{{ route('newscategory.insert') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-2" >Category Name</label>
                        <div class="col-sm-10">
                            <input type="text" required name="category_name" id="category_name" class="form-control" value="{{ old('category_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" >Category Description</label>
                        <div class="col-sm-10">
                            <textarea name="category_details" rows="10" required id="category_details" class="form-control">{{ old('category_details') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" >Category Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="category_image"  id="category_image" class="form-control" onchange="loadFile(event)">
                            <img id="output"/>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label"></label> 

                        <div class="col-sm-10"> 
                            {!! captcha_image_html('RegisterCaptcha') !!} 
                            <input type="text" class="form-control" name="CaptchaCode" id="CaptchaCode" required> 
                        </div> 
                    </div> 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-default" value="Add Category" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.width = 80;
        output.height = 60;
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

@endsection

