@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Categories</h3>

                        </div>

                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Categories table</h4>
                            <a href="{{url('admin/add-edit-category')}}" class="btn btn-primary mr-2">Add Category</a>
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
                                <table id="categories" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Category Id</th>
                                            <th>category</th>
                                            <th>Parent Category</th>
                                            <th>Section</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                        @if (isset($category['parentcategory']['category_name']) && !empty($category['parentcategory']['category_name']))
                                            @php
                                                $parent_category = $category['parentcategory']['category_name']
                                            @endphp
                                        @else
                                            @php
                                                $parent_category = "root";
                                            @endphp
                                        @endif
                                            <tr>
                                                <td>
                                                    {{ $category['id'] }}
                                                </td>
                                                <td>
                                                    {{ $category['category_name'] }}
                                                </td>
                                                <td>{{$parent_category}}</td>
                                                <td>{{$category['section']['name']}}</td>
                                                <td>{{$category['url']}}</td>

                                                <td>
                                                    @if ($category['status'] == 1)
                                                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{$category['id']}}" category_id='{{$category['id']}}'>
                                                        <i style="font-size: 25px" class="mdi mdi-bookmark-check" status='Active'></i>
                                                    </a>
                                                    @else
                                                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{$category['id']}}" category_id='{{$category['id']}}'>
                                                    <i style="font-size: 25px" class="mdi mdi-bookmark-outline" status='Inactive'></i>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>

                                                <a href="{{url('admin/add-edit-category/'.$category['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-pencil-box"></i>
                                                </a>
                                                {{-- <a title="Category" class="confirmDelete" href="{{url('admin/delete-category/'.$category['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-file-excel-box"></i>
                                                </a> --}}
                                                <a class="confirmDelete" href="javascript:void(0)" module='category' moduleid='{{$category['id']}}'>
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
