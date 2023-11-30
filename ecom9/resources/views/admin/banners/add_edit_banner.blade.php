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

                  <form class="forms-sample" @if (empty($banner['id']))
                  action="{{url('admin/add-edit-banner')}}"
                  @else
                  action="{{url('admin/add-edit-banner/'.$banner['id'])}}"
                  @endif  method="POST" enctype="multipart/form-data">@csrf


                  <div class="form-group">
                      <label for="type">Select Banner Type</label>
                      <select name="type" id="type" class="form-control text-dark">
                        <option value="">Select</option>
                        <option @if (!empty($banner['type']) && $banner['type']=='Slider')
                            selected
                        @endif value="Slider">Slider</option>

                        <option @if (!empty($banner['type']) && $banner['type']=='Fixed_1')
                            selected
                        @endif value="Fixed_1">Fixed 1</option>

                        <option @if (!empty($banner['type']) && $banner['type']=='Fixed_2')
                            selected
                        @endif value="Fixed_2">Fixed 2</option>

                        <option @if (!empty($banner['type']) && $banner['type']=='Fixed_3')
                            selected
                        @endif value="Fixed_3">Fixed 3</option>

                      </select>
                    </div>

                  <div class="form-group">
                        <label for="image">Banner photo</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if (!empty($banner['image']))
                            <a href="{{url('front/images/banner_images/'.$banner['image'])}}" target="_blank">View Image</a>
                            &nbsp;|&nbsp;
                            {{-- <a class="confirmDelete" href="javascript:void(0)" module='banner-image' moduleid='{{$banner['id']}}'>
                                Delete Image
                            </a> --}}
                        @endif
                      </div>

                    <div class="form-group">
                      <label for="link">Banner Link</label>
                      <input type="text" class="form-control" id="link" name="link" @if (!empty($banner['id']))
                      value="{{$banner['link']}}"
                      @else
                      value="{{old('link')}}"
                      @endif placeholder="Enter Banner Link" >
                    </div>

                    <div class="form-group">
                      <label for="title">Banner Title</label>
                      <input type="text" class="form-control" id="title" name="title" @if (!empty($banner['id']))
                      value="{{$banner['title']}}"
                      @else
                      value="{{old('title')}}"
                      @endif placeholder="Enter Banner Title" >
                    </div>

                    <div class="form-group">
                      <label for="alt">Banner ALT</label>
                      <input type="text" class="form-control" id="alt" name="alt" @if (!empty($banner['id']))
                      value="{{$banner['alt']}}"
                      @else
                      value="{{old('alt')}}"
                      @endif placeholder="Enter Banner ALT" >
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
