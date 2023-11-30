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
                  <h4 class="card-title">{{$title}}</h4>
                  <p class="card-description">

                  </p>
                  @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR!</strong> {{Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif
                  @if (Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>SUCCESS!</strong> {{Session::get('success_message')}}
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

                  <form class="forms-sample" @if (empty($product['id']))
                  action="{{url('admin/add-edit-product')}}"
                  @else
                  action="{{url('admin/add-edit-product/'.$product['id'])}}"
                  @endif  method="POST" enctype="multipart/form-data">@csrf

                    <div class="form-group">
                      <label for="product_name">Product Name</label>
                      <input type="text" class="form-control" id="product_name" name="product_name" @if (!empty($product['id']))
                      value="{{$product['product_name']}}"
                      @else
                      value="{{old('product_name')}}"
                      @endif placeholder="Enter Section Name" >
                    </div>

                    <div class="form-group">
                      <label for="category_id">Select Category</label>
                      <select name="category_id" id="category_id" class="form-control text-dark">
                        <option value="">Select</option>
                        @foreach ($categories as $section)
                            <optgroup label="{{$section['name']}}"></optgroup>
                            @foreach ($section['categories'] as $category)
                                <option
                                @if (!empty($product['category_id']==$category['id']))
                                    selected
                                @endif
                                {{-- {{$product['category_id']==$category['id'] ? 'selected' : ''}} --}}


                                value="{{$category['id']}}">&nbsp;&nbsp;-&nbsp;{{$category['category_name']}}</option>
                                @foreach ($category['subcategories'] as $subcategory)
                                    <option
                                    @if (!empty($product['category_id']==$subcategory['id']))
                                    selected
                                @endif
                                value="{{$subcategory['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;---&nbsp;{{$subcategory['category_name']}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                      </select>
                    </div>

                    <div class="loadFilters">
                        @include('admin.filters.category_filters')
                    </div>

                    <div class="form-group">
                      <label for="brand_id">Select Brand</label>
                      <select name="brand_id" id="brand_id" class="form-control text-dark">
                        <option value="">Select</option>
                        @foreach ($brands as $brand)
                            <option @if (!empty($product['brand_id']==$brand['id']))
                                    selected
                                @endif value="{{$brand['id']}}">{{$brand['name']}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="product_code">Product product_code</label>
                      <input type="text" class="form-control" id="product_code" name="product_code" @if (!empty($product['product_code']))
                      value="{{$product['product_code']}}"
                      @else
                      value="{{old('product_code')}}"
                      @endif placeholder="Enter product_code" >
                    </div>

                    <div class="form-group">
                      <label for="product_color">Product product_color</label>
                      <input type="text" class="form-control" id="product_color" name="product_color" @if (!empty($product['product_color']))
                      value="{{$product['product_color']}}"
                      @else
                      value="{{old('product_color')}}"
                      @endif placeholder="Enter product_color" >
                    </div>

                    <div class="form-group">
                      <label for="product_price">Product product_price</label>
                      <input type="text" class="form-control" id="product_price" name="product_price" @if (!empty($product['product_price']))
                      value="{{$product['product_price']}}"
                      @else
                      value="{{old('product_price')}}"
                      @endif placeholder="Enter product_price" >
                    </div>

                    <div class="form-group">
                      <label for="product_old_price">Product product_old_price</label>
                      <input type="text" class="form-control" id="product_old_price" name="product_old_price" @if (!empty($product['product_old_price']))
                      value="{{$product['product_old_price']}}"
                      @else
                      value="{{old('product_old_price')}}"
                      @endif placeholder="Enter product_old_price" >
                    </div>

                    <div class="form-group">
                      <label for="product_discount">Product product discount(%)</label>
                      <input type="text" class="form-control" id="product_discount" name="product_discount" @if (!empty($product['product_discount']))
                      value="{{$product['product_discount']}}"
                      @else
                      value="{{old('product_discount')}}"
                      @endif placeholder="Enter product_discount" >
                    </div>

                    <div class="form-group">
                      <label for="product_weight">Product product_weight</label>
                      <input type="text" class="form-control" id="product_weight" name="product_weight" @if (!empty($product['product_weight']))
                      value="{{$product['product_weight']}}"
                      @else
                      value="{{old('product_weight')}}"
                      @endif placeholder="Enter product_weight" >
                    </div>

                    <div class="form-group">
                      <label for="group_code">Product group_code</label>
                      <input type="text" class="form-control" id="group_code" name="group_code" @if (!empty($product['group_code']))
                      value="{{$product['group_code']}}"
                      @else
                      value="{{old('group_code')}}"
                      @endif placeholder="Enter group_code" >
                    </div>


                    <div class="form-group">
                        <label for="product_image">Product photo (Recommended Size 1000x1000)</label>
                        <input type="file" class="form-control" id="product_image" name="product_image">
                        @if (!empty($product['product_image']))
                            <a href="{{url('front/images/product_images/large/'.$product['product_image'])}}" target="_blank">View Image</a>
                            &nbsp;|&nbsp;
                            <a class="confirmDelete" href="javascript:void(0)" module='product-image' moduleid='{{$product['id']}}'>
                                Delete Image
                            </a>
                        @endif
                      </div>

                    <div class="form-group">
                        <label for="product_video">Product video (Recommended Size less then 2MB)</label>
                        <input type="file" class="form-control" id="product_video" name="product_video">
                        @if (!empty($product['product_video']))
                            <a href="{{url('front/videos/product_videos/'.$product['product_video'])}}" target="_blank">View Image</a>
                            &nbsp;|&nbsp;
                            <a class="confirmDelete" href="javascript:void(0)" module='product-video' moduleid='{{$product['id']}}'>
                                Delete video
                            </a>
                        @endif
                      </div>


                      <div class="form-group">
                        <label for="product_short_description">Product product_short_description</label>
                        <textarea class="form-control" id="product_short_description" name="product_short_description" placeholder="Enter product product_short_description" rows="4">
                            @if (!empty($product['id']))
                        {{$product['product_short_description']}}
                        @else
                        {{old('product_short_description')}}
                        @endif
                        </textarea>
                      </div>

                      <div class="form-group">
                        <label for="product_long_description">Product product_long_description</label>
                        <textarea class="form-control" id="product_long_description" name="product_long_description" placeholder="Enter product product_long_description" rows="4">
                            @if (!empty($product['id']))
                        {{$product['product_long_description']}}
                        @else
                        {{old('product_long_description')}}
                        @endif
                        </textarea>
                      </div>

                      <div class="form-group">
                        <label for="product_url">Product URL</label>
                        <input type="text" class="form-control" id="product_url" name="product_url" @if (!empty($product['id']))
                        value="{{$product['product_url']}}"
                        @else
                        value="{{old('product_url')}}"
                        @endif placeholder="Enter product URL" >
                      </div>

                      <div class="form-group">
                        <label for="meta_title">Product meta_title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" @if (!empty($product['id']))
                        value="{{$product['meta_title']}}"
                        @else
                        value="{{old('meta_title')}}"
                        @endif placeholder="Enter product meta_title" >
                      </div>

                      <div class="form-group">
                        <label for="meta_description">Product meta_description</label>
                        <input type="text" class="form-control" id="meta_description" name="meta_description" @if (!empty($product['id']))
                        value="{{$product['meta_description']}}"
                        @else
                        value="{{old('meta_description')}}"
                        @endif placeholder="Enter product meta_description" >
                      </div>

                      <div class="form-group">
                        <label for="meta_keywords">Product meta_keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" @if (!empty($product['id']))
                        value="{{$product['meta_keywords']}}"
                        @else
                        value="{{old('meta_keywords')}}"
                        @endif placeholder="Enter product meta_keywords" >
                      </div>

                      <div class="form-group">
                        <label for="schema">Product schema</label>
                        <input type="text" class="form-control" id="schema" name="schema" @if (!empty($product['id']))
                        value="{{$product['schema']}}"
                        @else
                        value="{{old('schema')}}"
                        @endif placeholder="Enter product schema" >
                      </div>

                      <div class="form-group">
                        <label for="is_featured">Featured Item</label>
                        <input type="checkbox" id="is_featured" name="is_featured" value="Yes"
                        @if (!empty($product['is_featured']) && $product['is_featured']=='Yes')
                            checked
                        @endif>
                      </div>

                      <div class="form-group">
                        <label for="is_bestseller">Best Seller Item</label>
                        <input type="checkbox" id="is_bestseller" name="is_bestseller" value="Yes"
                        @if (!empty($product['is_bestseller']) && $product['is_bestseller']=='Yes')
                            checked
                        @endif>
                      </div>


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
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
<script src="{{url('admin/js/custom.js')}}"></script>
@endsection
