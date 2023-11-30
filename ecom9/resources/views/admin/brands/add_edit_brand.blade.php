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

                  <form class="forms-sample" @if (empty($brand['id']))
                  action="{{url('admin/add-edit-brand')}}"
                  @else
                  action="{{url('admin/add-edit-brand/'.$brand['id'])}}"
                  @endif  method="POST" enctype="multipart/form-data">@csrf

                    <div class="form-group">
                      <label for="brand_name">Brand Name</label>
                      <input type="text" class="form-control" id="brand_name" name="brand_name" @if (!empty($brand['id']))
                      value="{{$brand['name']}}"
                      @else
                      value="{{old('brand_name')}}"
                      @endif placeholder="Enter Section Name" >
                    </div>


                    <div class="form-group">
                        <label for="brand_image">Brand photo</label>
                        <input type="file" class="form-control" id="brand_image" name="brand_image">
                        @if (!empty($brand['brand_image']))
                            <a href="{{url('front/images/brand_images/'.$brand['brand_image'])}}" target="_blank">View Image</a>
                            &nbsp;|&nbsp;
                            <a class="confirmDelete" href="javascript:void(0)" module='brand-image' moduleid='{{$brand['id']}}'>
                                Delete Image
                            </a>
                        @endif
                      </div>


                      <div class="form-group">
                        <label for="description">Brand description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Enter brand description" rows="4">
                            @if (!empty($brand['id']))
                        {{$brand['description']}}
                        @else
                        {{old('description')}}
                        @endif
                        </textarea>
                      </div>

                      <div class="form-group">
                        <label for="url">Brand URL</label>
                        <input type="text" class="form-control" id="url" name="url" @if (!empty($brand['id']))
                        value="{{$brand['url']}}"
                        @else
                        value="{{old('url')}}"
                        @endif placeholder="Enter brand URL" >
                      </div>

                      <div class="form-group">
                        <label for="meta_title">Brand meta_title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" @if (!empty($brand['id']))
                        value="{{$brand['meta_title']}}"
                        @else
                        value="{{old('meta_title')}}"
                        @endif placeholder="Enter brand meta_title" >
                      </div>

                      <div class="form-group">
                        <label for="meta_description">Brand meta_description</label>
                        <input type="text" class="form-control" id="meta_description" name="meta_description" @if (!empty($brand['id']))
                        value="{{$brand['meta_description']}}"
                        @else
                        value="{{old('meta_description')}}"
                        @endif placeholder="Enter brand meta_description" >
                      </div>

                      <div class="form-group">
                        <label for="meta_keywords">Brand meta_keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" @if (!empty($brand['id']))
                        value="{{$brand['meta_keywords']}}"
                        @else
                        value="{{old('meta_keywords')}}"
                        @endif placeholder="Enter brand meta_keywords" >
                      </div>

                      <div class="form-group">
                        <label for="schema">Brand schema</label>
                        <input type="text" class="form-control" id="schema" name="schema" @if (!empty($brand['id']))
                        value="{{$brand['schema']}}"
                        @else
                        value="{{old('schema')}}"
                        @endif placeholder="Enter brand schema" >
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
