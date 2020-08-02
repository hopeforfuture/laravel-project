@extends('layouts.master')

@section('content')
@include('inc.message')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <!-- Posts list -->
        @if(!empty($articles))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Articles List </h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('article.add') }}">Create Article</a> 
                    <a class="btn btn-info" href="{{ route('article.export') }}"> Export to Excel</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                        <th>Serial No</th>
                        <th>Article title</th>
                        <th>Article Short Description</th>                
                        <th>Article Image</th>
                        <th>Article Category</th>
                        <th>Created</th>
                        <th>Action</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($articles as $item)
                        <tr>
                            <td class="table-text">
                                <div>{{++$i}}</div>
                            </td>
                            <td class="table-text">
                                <div>                                   
                                    {!! \Illuminate\Support\Str::words(htmlspecialchars($item->title, ENT_QUOTES), 10,'....')  !!}
                                </div>
                            </td>
                            <td class="table-text">
                                <div>
                                    {!! \Illuminate\Support\Str::words(htmlspecialchars($item->body, ENT_QUOTES), 10,'....')  !!}
                                    
                                </div>
                            </td>                          
                            <td class="table-text">
                                @if(!empty($item->article_img))
                                    <div>
                                        <img src='{{ asset("uploads/article/thumb/$item->article_img")}}'  />
                                    </div>
                                @else
                                    <div>
                                        <img src='{{ asset("img/img-not-avbl.jpg")}}' width="80" height="60" />
                                    </div>
                                @endif
                                
                            </td>
                            <td class="table-text">
                                {{ $categories[$item->article_category] }}
                            </td>
                            <td class="table-text">
                                <div>{{$item->created_at}}</div>
                            </td>
                            <td>
                                <a target="_blank" href="{{ route('article.edit', $item->id) }}" class="label label-warning">Edit</a>&nbsp;
                                <a href="Javascript:void(0);" article_id="{{ $item->id }}" class="label label-info article-view">View</a>&nbsp;
                                <a href="{{ route('article.delete', $item->id) }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$articles->appends(request()->query())->links('vendor.pagination.bootstrap-4')}}
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
        
        $("body").on("click", ".article-view", function(){
            var article_id = $(this).attr("article_id");
            $.ajax({
                type: 'POST',
                url: "{{ route('article.view') }}",
                data: {id : article_id},
                dataType: 'json',
                success:function(response) {
                    console.log(response.title);
                    $("#news_title").html(response.title);
                    $("#news_category").html(response.category_name);
                    $("#news_detail").html(response.body);
                    $("#news_created_at").html(response.created_at);
                    
                    if(response.article_img != null) {
                        var src = '{{ asset("uploads/article/thumb") }}' + "/" + response.article_img;
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
                <h4 class="modal-title" style="color:red;font-weight:bold;">Article Detail View</h4>
            </div>
            
            <div class="modal-body">
                <table class="table table-striped task-table">
                    <tr>
                        <td class="table-text">Article Title</td>
                        <td class="table-text">:</td>
                        <td class="table-text" id="news_title"></td>
                    </tr>
                    <tr>
                        <td class="table-text">Article Category</td>
                        <td class="table-text">:</td>
                        <td class="table-text" id="news_category"></td>
                    </tr>
                    <tr>
                        <td class="table-text" style="vertical-align: top;">Article Detail</td>
                        <td class="table-text" style="vertical-align: top;">:</td>
                        <td class="table-text" id="news_detail"></td>
                    </tr>
                    <tr>
                        <td class="table-text">Article Image</td>
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
