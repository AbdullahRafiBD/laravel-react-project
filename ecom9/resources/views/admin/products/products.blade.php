@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Products</h3>

                        </div>

                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Products table</h4>
                            <a href="{{url('admin/add-edit-product')}}" class="btn btn-primary mr-2">Add product</a>
                            {{-- <p class="card-description">
                                Add class <code>.table-bordered</code>
                            </p> --}}
                            @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>SUCCESS!</strong> {{Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="table-responsive pt-3">
                                <table id="products" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Id</th>
                                            <th>Product</th>
                                            <th>Product Image</th>
                                            <th>Category</th>
                                            <th>Section</th>
                                            <th>Added By</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)

                                            <tr>
                                                <td>
                                                    {{ $product['id'] }}
                                                </td>

                                                <td>{{$product['product_name']}}</td>
                                                <td>
                                                    @if (!empty($product['product_image']))
                                                        <img style="width: 80px; height:80px;" src="{{asset('front/images/product_images/small/'.$product['product_image'])}}" alt="">
                                                    @else
                                                        <img style="width: 80px; height:80px;" src="{{asset('front/images/product_images/small/no-image.png')}}" alt="">
                                                    @endif
                                                </td>
                                                <td>{{$product['category']['category_name']}}</td>
                                                <td>{{$product['section']['name']}}</td>
                                                <td>
                                                    @if ($product['admin_type']=='vendor')
                                                        <a target="_blank" href="{{url('admin/view-vendor-details/'.$product['admin_id'])}}">{{ucfirst($product['admin_type'])}}</a>
                                                    @else
                                                        {{ucfirst($product['admin_type'])}}
                                                    @endif
                                                </td>
                                                <td>{{$product['product_url']}}</td>

                                                <td>
                                                    @if ($product['status'] == 1)
                                                    <a href="javascript:void(0)" class="updateProductStatus" id="product-{{$product['id']}}" product_id='{{$product['id']}}'>
                                                        <i style="font-size: 25px" class="mdi mdi-bookmark-check" status='Active'></i>
                                                    </a>
                                                    @else
                                                    <a href="javascript:void(0)" class="updateProductStatus" id="product-{{$product['id']}}" product_id='{{$product['id']}}'>
                                                    <i style="font-size: 25px" class="mdi mdi-bookmark-outline" status='Inactive'></i>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>

                                                <a title="Edit" href="{{url('admin/add-edit-product/'.$product['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-pencil-box"></i>
                                                </a>
                                                <a title="Add Attributes" href="{{url('admin/add-edit-attributes/'.$product['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-plus-box"></i>
                                                </a>
                                                <a title="Add Multiple Image" href="{{url('admin/add-images/'.$product['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-library-plus"></i>
                                                </a>
                                                <a title="Delete" class="confirmDelete" href="javascript:void(0)" module='product' moduleid='{{$product['id']}}'>
                                                    <i style="font-size: 25px" class="mdi mdi-file-excel-box"></i>
                                                </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
    </div>
@endsection

@section('script')
    <script src="{{ url('admin/js/custom.js') }}"></script>
@endsection
