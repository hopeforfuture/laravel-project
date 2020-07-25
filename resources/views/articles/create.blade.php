@extends('layouts.master')
@section('content')
    @include('inc.message')
    <h1>Create Article</h1>
    {!! Form::open(['route' => 'article.insert', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text', 'required'=>'required'])}}
        </div>
        <div class="form-group">
            {{Form::label('article_category', 'Category')}}
            {{Form::select('article_category', $categories, null, ['placeholder' => 'Select a Category...', 'class' => 'form-control', 'required'=>'required'])}}
        </div>
        <div class="form-group">
            {{Form::file('article_img')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
