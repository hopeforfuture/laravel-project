@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <!-- Posts list -->
        @if(!empty($news_category_list))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Category List </h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('newscategory.add') }}"> Create New Category</a> 
                    <a class="btn btn-success" href="{{ route('news.index') }}">News</a> 
                    <a class="btn btn-info" href="{{ route('newscategory.export') }}"> Export to Excel</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                        <th>Serial No</th>
                        <th>Category Name</th>
                        <th>Category Description</th>                
                        <th>Category Image</th>
                        <th>Created</th>
                        <th>Action</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($news_category_list as $item)
                        <tr>
                            <td class="table-text">
                                <div>{{++$i}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$item->category_name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$item->category_details}}</div>
                            </td>                          
                            <td class="table-text">
                                @if(!empty($item->category_image))
                                    <div>
                                        <img src='{{ asset("uploads/$item->category_image")}}' width="80" height="60" />
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
                                <a href="{{ route('newscategory.edit', $item->id) }}" class="label label-warning">Edit</a>&nbsp;
                                <a href="Javascript:void(0);" news_category_id="{{ $item->id }}" class="label label-info category-view">View</a>&nbsp;
                                <a href="{{ route('newscategory.delete', $item->id) }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$news_category_list->links('vendor.pagination.bootstrap-4')}}
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
        
        $("body").on("click", ".category-view", function(){
            var news_cat_id = $(this).attr("news_category_id");
            $.ajax({
                type: 'POST',
                url: "{{ route('newscategory.view') }}",
                data: {category_id : news_cat_id},
                dataType: 'json',
                success:function(response) {
                    console.log(response.id);
                    $("#item_name").html(response.category_name);
                    $("#item_details").html(response.category_details);
                    
                    if(response.category_image != null) {
                        var src = '{{ asset("uploads") }}' + "/" + response.category_image;
                        $("#item_img").attr('src', src);
                    } else {
                        $("#item_img").attr('src', '{{ asset("img/img-not-avbl.jpg") }}');
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
                <h4 class="modal-title" style="color:red;font-weight:bold;">News Category View</h4>
            </div>
            
            <div class="modal-body">
                <table class="table table-striped task-table">
                    <tr>
                        <td class="table-text">Category Name</td>
                        <td class="table-text">:</td>
                        <td class="table-text" id="item_name"></td>
                    </tr>
                    <tr>
                        <td class="table-text" style="vertical-align: top;">Category Description</td>
                        <td class="table-text" style="vertical-align: top;">:</td>
                        <td class="table-text" id="item_details"></td>
                    </tr>
                    <tr>
                        <td class="table-text">Category Image</td>
                        <td class="table-text">:</td>
                        <td class="table-text">
                            <img id="item_img" width="80" height="60" />
                        </td>
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
