@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <!-- Posts list -->
        @if(!empty($news_list))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>News List </h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('newscategory.index') }}">Category</a> 
                    <a class="btn btn-success" href="{{ route('news.add') }}">Create News</a> 
                    <a class="btn btn-info" href="{{ route('news.export') }}"> Export to Excel</a>
                    <a id="btnShow" class="btn btn-info" href="Javascript: void(0);"> Show Filter</a>
                </div>
            </div>
            @include('common.filter')
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                        <th>Serial No</th>
                        <th>News title</th>
                        <th>News Short Description</th>                
                        <th>News Image</th>
                        <th>Created</th>
                        <th>Action</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($news_list as $item)
                        <tr>
                            <td class="table-text">
                                <div>{{++$i}}</div>
                            </td>
                            <td class="table-text">
                                <div>                                   
                                    {!! \Illuminate\Support\Str::words(htmlspecialchars($item->news_title, ENT_QUOTES), 10,'....')  !!}
                                </div>
                            </td>
                            <td class="table-text">
                                <div>
                                    {!! \Illuminate\Support\Str::words(htmlspecialchars($item->news_description, ENT_QUOTES), 10,'....')  !!}
                                    
                                </div>
                            </td>                          
                            <td class="table-text">
                                @if(!empty($item->news_img_thumb))
                                    <div>
                                        <img src='{{ asset("uploads/news/thumb/$item->news_img_thumb")}}'  />
                                    </div>
                                @else
                                    <div>
                                        <img src='{{ asset("img/img-not-avbl.jpg")}}' width="80" height="60" />
                                    </div>
                                @endif
                                
                            </td>
                            <td class="table-text">
                                <div>{{$item->created_at}}</div>
                            </td>
                            <td>
                                <a href="{{ route('news.edit', $item->id) }}" class="label label-warning">Edit</a>&nbsp;
                                <a href="Javascript:void(0);" news_id="{{ $item->id }}" class="label label-info news-view">View</a>&nbsp;
                                <a href="{{ route('news.delete', $item->id) }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$news_list->appends(request()->query())->links('vendor.pagination.bootstrap-4')}}
            </ul>
        </nav>
        @endif
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("body").on("click", ".news-view", function(){
            var news_id = $(this).attr("news_id");
            $.ajax({
                type: 'POST',
                url: "{{ route('news.view') }}",
                data: {id : news_id},
                dataType: 'json',
                success:function(response) {
                    console.log(response.news_title);
                    $("#news_title").html(response.news_title);
                    $("#news_category").html(response.category_name);
                    $("#news_detail").html(response.news_description);
                    $("#news_created_at").html(response.created_at);
                    
                    if(response.news_img_thumb != null) {
                        var src = '{{ asset("uploads/news/thumb") }}' + "/" + response.news_img_thumb;
                        $("#news_img").attr('src', src);
                    } else {
                        $("#news_img").attr('src', '{{ asset("img/img-not-avbl.jpg") }}');
                    }
                    
                    $("#viewmodal").modal();
                    
                }
            });
        });
        
    });
</script>

<div class="modal fade" id="viewmodal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:red;font-weight:bold;">News Detail View</h4>
            </div>
            
            <div class="modal-body">
                <table class="table table-striped task-table">
                    <tr>
                        <td class="table-text">News Title</td>
                        <td class="table-text">:</td>
                        <td class="table-text" id="news_title"></td>
                    </tr>
                    <tr>
                        <td class="table-text">News Category</td>
                        <td class="table-text">:</td>
                        <td class="table-text" id="news_category"></td>
                    </tr>
                    <tr>
                        <td class="table-text" style="vertical-align: top;">News Detail</td>
                        <td class="table-text" style="vertical-align: top;">:</td>
                        <td class="table-text" id="news_detail"></td>
                    </tr>
                    <tr>
                        <td class="table-text">News Image</td>
                        <td class="table-text">:</td>
                        <td class="table-text">
                            <img id="news_img"  />
                        </td>
                    </tr>
                    <tr>
                        <td class="table-text" style="vertical-align: top;">Created At</td>
                        <td class="table-text" style="vertical-align: top;">:</td>
                        <td class="table-text" id="news_created_at"></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@endsection
