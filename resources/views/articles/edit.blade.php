@extends('layouts.master')
@section('content')
@include('inc.message')
<h1>Edit Article</h1>
{!! Form::model($article,['route' => ['article.update', $article], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', null,  ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', null,  ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text', 'required'=>'required'])}}
    </div>
    <div class="form-group">
        {{Form::label('article_category', 'Category')}}
        {{Form::select('article_category', $categories, null, ['placeholder' => 'Select a Category...', 'class' => 'form-control', 'required'=>'required'])}}
    </div>
    <div class="form-group">
        {{Form::file('article_img')}}
        <br/>
        @if(!empty($article->article_img)) 
            <img id="proimg" src='{{ asset("uploads/article/thumb/$article->article_img")}}'  />
        @else
            <img src='{{ asset("img/img-not-avbl.jpg")}}' width="80" height="60" />
        @endif
    </div>
    <div class="form-group">
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    </div>

{!! Form::close() !!}
@endsection
