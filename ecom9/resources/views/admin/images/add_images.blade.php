@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Catalogue Management</h3>
                            {{-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> --}}
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Images</h4>
                            <p class="card-description">

                            </p>
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>ERROR!</strong> {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>SUCCESS!</strong> {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="forms-sample" action="{{ url('admin/add-images/' . $product['id']) }}"
                                method="POST" enctype="multipart/form-data">@csrf

                                <div class="form-group">
                                    <label for="product_name">Product Name:</label>
                                    &nbsp; {{ $product['product_name'] }}
                                </div>



                                <div class="form-group">
                                    <label for="product_code">Product product_code:</label>
                                    &nbsp; {{ $product['product_code'] }}
                                </div>

                                <div class="form-group">
                                    <label for="product_color">Product product_color: </label>
                                    &nbsp; {{ $product['product_color'] }}
                                </div>

                                <div class="form-group">
                                    <label for="product_price">Product product_price:</label>
                                    &nbsp;{{ $product['product_price'] }}
                                </div>

                                <div class="form-group">
                                    <label for="product_image">Product photo (Recommended Size 1000x1000)</label>

                                    @if (!empty($product['product_image']))
                                        <img style="width: 120px"
                                            src="{{ asset('front/images/product_images/small/' . $product['product_image']) }}">
                                    @else
                                        <img style="width: 120px"
                                            src="{{ asset('front/images/product_images/small/no-image.png') }}">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <input type="file" name="images[]" id="images" multiple>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Products table</h4>
                            <a href="{{ url('admin/add-edit-product') }}" class="btn btn-primary mr-2">Add product</a>
                            {{-- <p class="card-description">
                                Add class <code>.table-bordered</code>
                            </p> --}}
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>SUCCESS!</strong> {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="table-responsive pt-3">
                                <form action="{{ url('admin/edit-attributes/' . $product['id']) }}" method="post">@csrf
                                    <table id="products" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product Id</th>
                                                <th>image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product['images'] as $image)
                                                <input style="display: none" type="text" name="attributeId[]"
                                                    value="{{ $image['id'] }}">
                                                <tr>
                                                    <td>
                                                        {{ $image['id'] }}
                                                    </td>
                                                    <td>
                                                        <img style="width: 120px"
                                                            src="{{ asset('front/images/product_images/small/' . $image['image']) }}">
                                                    </td>


                                                    <td>
                                                        @if ($image['status'] == 1)
                                                            <a href="javascript:void(0)" class="updateImageStatus"
                                                                id="image-{{ $image['id'] }}"
                                                                image_id='{{ $image['id'] }}'>
                                                                <i style="font-size: 25px" class="mdi mdi-bookmark-check"
                                                                    status='Active'></i>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)" class="updateImageStatus"
                                                                id="image-{{ $image['id'] }}"
                                                                image_id='{{ $image['id'] }}'>
                                                                <i style="font-size: 25px" class="mdi mdi-bookmark-outline"
                                                                    status='Inactive'></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="confirmDelete" href="javascript:void(0)" module='image'
                                                            moduleid='{{ $image['id'] }}'>
                                                            <i style="font-size: 25px" class="mdi mdi-file-excel-box"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary mr-2">Update Attribute</button>
                                </form>

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
