@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif

        @php
        $i = 0;
        $j = 0;
        @endphp

        <!-- Original Posts list -->
        @if(!empty($originals))

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Original News List </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <th>Serial No</th>
                    <th>News Category</th>
                    <th>Published Time</th>
                    <th>Article</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($originals as $org)
                        <tr>
                            <td class="table-text">
                                <div>{{++$i}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$org['category']}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ date('F j, Y', strtotime($org['date'])) }}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ $org['article'] }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif


        @if(!empty($sortednews))

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Sorted News List </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <th>Serial No</th>
                    <th>News Category</th>
                    <th>Published Time</th>
                    <th>Article</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($sortednews as $srt)
                        <tr>
                            <td class="table-text">
                                <div>{{++$j}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$srt['category']}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ date('F j, Y', $srt['date']) }}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ $srt['article'] }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection