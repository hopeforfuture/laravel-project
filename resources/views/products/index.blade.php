@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <!-- Posts list -->
        @if(!empty($products))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Products List </h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.add') }}"> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <th>Serial No</th>
                    <th>Product Name</th>
                    <th>Product Details</th>
                    <th>Product Price(USD)</th>
                    <th>Product Image</th>
                    <th>Created</th>
                    <th>Action</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="table-text">
                                <div>{{++$i}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$product->name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$product->details}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{number_format($product->price)}}</div>
                            </td>
                            <td class="table-text">
                                <div><img src='{{ asset("uploads/$product->product_image")}}' width="80" height="60" /></div>
                            </td>
                            <td class="table-text">
                                <div>{{$product->created}}</div>
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="label label-warning">Edit</a>
                                <a href="{{ route('products.delete', $product->id) }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$products->links('vendor.pagination.bootstrap-4')}}
            </ul>
        </nav>
        @endif
    </div>
</div>
@endsection