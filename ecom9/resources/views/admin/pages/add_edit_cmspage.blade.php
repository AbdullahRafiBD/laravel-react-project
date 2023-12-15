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
                            <h4 class="card-title">{{ $title }}</h4>
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

                            <form class="forms-sample"
                                @if (empty($cmspage['id'])) action="{{ url('admin/add-edit-cms-page') }}"
                  @else
                  action="{{ url('admin/add-edit-cms-page/' . $cmspage['id']) }}" @endif
                                method="POST" enctype="multipart/form-data">@csrf

                                <div class="form-group">
                                    <label for="title">CmsPage Name</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        @if (!empty($cmspage['id'])) value="{{ $cmspage['title'] }}"
                      @else
                      value="{{ old('title') }}" @endif
                                        placeholder="Enter Section Name">
                                </div>





                                <div class="form-group">
                                    <label for="description">CmsPage description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter cmspage description"
                                        rows="4">
                            @if (!empty($cmspage['id']))
{{ $cmspage['description'] }}
@else
{{ old('description') }}
@endif
                        </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="url">CmsPage URL</label>
                                    <input type="text" class="form-control" id="url" name="url"
                                        @if (!empty($cmspage['id'])) value="{{ $cmspage['url'] }}"
                        @else
                        value="{{ old('url') }}" @endif
                                        placeholder="Enter cmspage URL">
                                </div>

                                <div class="form-group">
                                    <label for="meta_title">CmsPage meta_title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        @if (!empty($cmspage['id'])) value="{{ $cmspage['meta_title'] }}"
                        @else
                        value="{{ old('meta_title') }}" @endif
                                        placeholder="Enter cmspage meta_title">
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">CmsPage meta_description</label>
                                    <input type="text" class="form-control" id="meta_description" name="meta_description"
                                        @if (!empty($cmspage['id'])) value="{{ $cmspage['meta_description'] }}"
                        @else
                        value="{{ old('meta_description') }}" @endif
                                        placeholder="Enter cmspage meta_description">
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
    <script src="{{ url('admin/js/custom.js') }}"></script>
@endsection
