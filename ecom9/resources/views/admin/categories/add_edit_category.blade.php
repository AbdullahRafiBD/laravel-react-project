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

                  <form class="forms-sample" @if (empty($category['id']))
                  action="{{url('admin/add-edit-category')}}"
                  @else
                  action="{{url('admin/add-edit-category/'.$category['id'])}}"
                  @endif  method="POST" enctype="multipart/form-data">@csrf

                    <div class="form-group">
                      <label for="category_name">Category Name</label>
                      <input type="text" class="form-control" id="category_name" name="category_name" @if (!empty($category['id']))
                      value="{{$category['category_name']}}"
                      @else
                      value="{{old('category_name')}}"
                      @endif placeholder="Enter Section Name" >
                    </div>

                    <div class="form-group">
                      <label for="section_id">Select Section</label>
                      <select name="section_id" id="section_id" class="form-control" style="color: #000">
                        <option value="">Select</option>
                        @foreach ($getSections as $section)
                        <option value="{{$section['id']}}" @if (!empty($category['section_id']) && $category['section_id']==$section['id'])
                            selected
                        @endif>{{$section['name']}}</option>
                        @endforeach
                      </select>
                    </div>


                    {{-- <div class="form-group">
                      <label for="parent_id">Select Section</label>
                      <select name="parent_id" id="parent_id" class="form-control">
                        <option value="0">Main Category</option>

                      </select>
                    </div> --}}
                    <div id="appendCategoriesLevel">
                        @include('admin.categories.append_categories_level')
                    </div>

                    <div class="form-group">
                        <label for="category_image">Category photo</label>
                        <input type="file" class="form-control" id="category_image" name="category_image">
                        @if (!empty($category['category_image']))
                            <a href="{{url('front/images/category_images/'.$category['category_image'])}}" target="_blank">View Image</a>
                            &nbsp;|&nbsp;
                            <a class="confirmDelete" href="javascript:void(0)" module='category-image' moduleid='{{$category['id']}}'>
                                Delete Image
                            </a>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="category_discount">Category Discount</label>
                        <input type="text" class="form-control" id="category_discount" name="category_discount" @if (!empty($category['id']))
                        value="{{$category['category_discount']}}"
                        @else
                        value="{{old('category_discount')}}"
                        @endif placeholder="Enter category discount" >
                      </div>

                      <div class="form-group">
                        <label for="description">Category description</label>
                        <textarea class="form-control" id="description" name="description" @if (!empty($category['id']))
                        value="{{$category['description']}}"
                        @else
                        value="{{old('description')}}"
                        @endif placeholder="Enter category description"  cols="30" rows="10"></textarea>
                        {{-- <input type="text" class="form-control" id="description" name="description" @if (!empty($category['id']))
                        value="{{$category['description']}}"
                        @else
                        value="{{old('description')}}"
                        @endif placeholder="Enter category description" > --}}
                      </div>

                      <div class="form-group">
                        <label for="url">Category URL</label>
                        <input type="text" class="form-control" id="url" name="url" @if (!empty($category['id']))
                        value="{{$category['url']}}"
                        @else
                        value="{{old('url')}}"
                        @endif placeholder="Enter category URL" >
                      </div>

                      <div class="form-group">
                        <label for="meta_title">Category meta_title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" @if (!empty($category['id']))
                        value="{{$category['meta_title']}}"
                        @else
                        value="{{old('meta_title')}}"
                        @endif placeholder="Enter category meta_title" >
                      </div>

                      <div class="form-group">
                        <label for="meta_description">Category meta_description</label>
                        <input type="text" class="form-control" id="meta_description" name="meta_description" @if (!empty($category['id']))
                        value="{{$category['meta_description']}}"
                        @else
                        value="{{old('meta_description')}}"
                        @endif placeholder="Enter category meta_description" >
                      </div>

                      <div class="form-group">
                        <label for="meta_keywords">Category meta_keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" @if (!empty($category['id']))
                        value="{{$category['meta_keywords']}}"
                        @else
                        value="{{old('meta_keywords')}}"
                        @endif placeholder="Enter category meta_keywords" >
                      </div>

                      <div class="form-group">
                        <label for="schema">Category schema</label>
                        <input type="text" class="form-control" id="schema" name="schema" @if (!empty($category['id']))
                        value="{{$category['schema']}}"
                        @else
                        value="{{old('schema')}}"
                        @endif placeholder="Enter category schema" >
                      </div>


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
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
