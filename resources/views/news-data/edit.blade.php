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
                Update News <a href="{{ route('news.index') }}" class="label label-primary pull-right">Back</a>
            </div>
            <div class="panel-body">
                <form action="{{ route('news.update', $news->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-2" >News Title</label>
                        <div class="col-sm-10">
                            <input type="text" required name="news_title" id="news_title" class="form-control" value="{{ $news->news_title }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2" >News Category</label>
                        <div class="col-sm-10">
                            <select name="news_category_id" id="news_category_id" class="form-control" required>
                                <option value="">---Select Category---</option>
                                @if(!empty($categories))
                                    @foreach($categories as $key=>$val)
                                        <option @if($key == $news->news_category_id) selected @endif value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                @endif
                            </select>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2" >News Content</label>
                        <div class="col-sm-10">
                            <textarea name="news_description" rows="10" required id="news_description" class="form-control">{{ $news->news_description  }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2" >News Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="news_image"  id="news_image" class="form-control" onchange="loadFile(event)">
                            @if(!empty($news->news_img_thumb)) 
                                <img id="proimg" src='{{ asset("uploads/news/thumb/$news->news_img_thumb")}}'  />
                            @else
                                <img src='{{ asset("img/img-not-avbl.jpg")}}' width="80" height="60" />
                            @endif
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
                            <input type="submit" class="btn btn-default" value="Save" />
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

