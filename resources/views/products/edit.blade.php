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
                Edit a  Product <a href="{{ route('products.index') }}" class="label label-primary pull-right">Back</a>
            </div>
            <div class="panel-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-2" >Product Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" >Product Details</label>
                        <div class="col-sm-10">
                            <textarea name="details" id="details" class="form-control">{{ $product->details }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" >Product Price</label>
                        <div class="col-sm-10">
                            <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" >Product Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="product_image" id="product_image" class="form-control" onchange="loadFile(event)"><br/>
                            <img id="proimg" src='{{ asset("uploads/$product->product_image")}}' width="80" height="60" />
                            <img id="output"/>
                        </div>
                    </div>


                    <div class="form-group"> 
                        <label class="col-sm-2 control-label"></label> 

                        <div class="col-sm-3"> 
                            {!! captcha_image_html('RegisterCaptcha') !!} 
                            <input type="text" class="form-control" name="CaptchaCode" id="CaptchaCode" required> 
                        </div> 
                    </div> 


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                                                    <!--<input type="hidden" name="old_img" id="old_img" value="{{$product->product_image}}" />-->
                            <input type="submit" class="btn btn-default" value="Update Product" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.width = 80;
        output.height = 60;
        document.getElementById('proimg').style = 'display:none;';
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>