@php
    use App\Models\Category;
@endphp
@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Filters</h3>

                        </div>

                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Categories table</h4>
                            <a href="{{url('admin/add-edit-filter')}}" class="btn btn-primary mr-2">Add Filter</a>
                            <a href="{{url('admin/filters-values')}}" class="btn btn-primary mr-2">View Filter Values</a>
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
                                <table id="filters" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Filter Id</th>
                                            <th>filter_name</th>
                                            <th>filter_column</th>
                                            <th>cat_ids</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filters as $filter)

                                            <tr>
                                                <td>
                                                    {{ $filter['id'] }}
                                                </td>

                                                <td>{{$filter['filter_name']}}</td>
                                                <td>{{$filter['filter_column']}}</td>
                                                <td>
                                                    {{-- {{$filter['cat_ids']}} --}}
                                                    @php
                                                        $catIds = explode(',',$filter['cat_ids']);
                                                        foreach ($catIds as $key => $catId) {
                                                           $category_name = Category::getCategoryName($catId);
                                                           echo $category_name.', ';
                                                        }
                                                    @endphp
                                                </td>

                                                <td>
                                                    @if ($filter['status'] == 1)
                                                    <a href="javascript:void(0)" class="updateFilterStatus" id="filter-{{$filter['id']}}" filter_id='{{$filter['id']}}'>
                                                        <i style="font-size: 25px" class="mdi mdi-bookmark-check" status='Active'></i>
                                                    </a>
                                                    @else
                                                    <a href="javascript:void(0)" class="updateFilterStatus" id="filter-{{$filter['id']}}" filter_id='{{$filter['id']}}'>
                                                    <i style="font-size: 25px" class="mdi mdi-bookmark-outline" status='Inactive'></i>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>

                                                <a href="{{url('admin/add-edit-filter/'.$filter['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-pencil-box"></i>
                                                </a>
                                                {{-- <a title="Category" class="confirmDelete" href="{{url('admin/delete-category/'.$category['id'])}}">
                                                    <i style="font-size: 25px" class="mdi mdi-file-excel-box"></i>
                                                </a> --}}
                                                <a class="confirmDelete" href="javascript:void(0)" module='filter' moduleid='{{$filter['id']}}'>
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
