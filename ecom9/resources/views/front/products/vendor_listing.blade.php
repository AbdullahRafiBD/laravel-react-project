
@extends('front.layout.layout')
@section('content')


<!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>{{$getVendorShop}}</h2>
                <ul class="bread-crumb">

                    {{-- BreadCrams --}}
                    {{-- @php
                        echo $categoryDetails['breadcrumbs'];
                    @endphp --}}

                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-80">
        <div class="container">
            <!-- Shop-Intro -->
            <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="has-separator">
                        {{$getVendorShop}}
                    </li>
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <div class="row">
                <!-- Shop-Left-Side-Bar-Wrapper -->

                {{-- @include('front.products.filters') --}}

                <!-- Shop-Left-Side-Bar-Wrapper /- -->
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                        <div class="shop-settings">
                            <a id="list-anchor" >
                                <i class="fas fa-th-list"></i>
                            </a>
                            <a id="grid-anchor" class="active">
                                <i class="fas fa-th"></i>
                            </a>
                        </div>
                        <!-- Toolbar Sorter 1  -->


                        <!-- //end Toolbar Sorter 1  -->
                        <!-- Toolbar Sorter 2  -->
                        {{-- <div class="toolbar-sorter-2">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="show-records">Show Records Per Page</label>
                                <select class="select-box" id="show-records">
                                    <option selected="selected" value="">Showing: {{count($categoryProducts)}}</option>
                                    <option value="">Showing: All</option>
                                </select>
                            </div>
                        </div> --}}
                        <!-- //end Toolbar Sorter 2  -->
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Row-of-Product-Container -->
                    <div class="filter_products">
                        @include('front.products.vendor_products_listing')
                    </div>
                    <!-- Row-of-Product-Container /- -->

                    @if (isset($_GET['sort']))
                    <div>
                        {{$vendorProducts->appends(['sort'=>$_GET['sort']])->links()}}
                    </div>
                    @else
                    <div>
                        {{$vendorProducts->links()}}
                    </div>
                    @endif


                    {{-- <div>
                        {{$categoryDetails['categoryDetails']['description']}}
                    </div> --}}
                </div>

                <!-- Shop-Right-Wrapper /- -->



            </div>
        </div>
    </div>
    <!-- Shop-Page /- -->


@endsection
