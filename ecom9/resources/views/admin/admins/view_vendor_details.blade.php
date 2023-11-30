@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Vendor Details</h3>
                            <h6 class="font-weight-normal mb-0"><a href="{{url('admin/admins/vendor')}}">Back to Vendors</a></h6>
                        </div>

                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Personal Information</h4>

                                        <p class="card-description">
                                            Personal info
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['name']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['email']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['address']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">city</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['city']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">state</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['state']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">country</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['country']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">pincode</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['pincode']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['mobile']}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!empty($vendorDetails['image']))
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image</label>
                                                        <div class="col-sm-9 ">
                                                            <img style="width: 100PX" src="{{ url('admin/images/photos/' . $vendorDetails['image']) }}" alt="">
                                                            <a target="_blank"
                                                    href="{{ url('admin/images/photos/' . $vendorDetails['image']) }}">view
                                                    image</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Business Information</h4>


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                         {{-- value="{{$vendorDetails['vendor_business']['shop_name']}}" --}}
                                                         @if (isset($vendorDetails['vendor_business']['shop_name']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_name'] }}"
                                                        @endif
                                                         readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_address']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_address'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_city</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_city']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_city'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_state</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_state']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_state'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_country</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_country']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_country'] }}"
                                                        @endif
                                                         readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_pincode</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_pincode']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_mobile']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_website</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_website']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_website'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">shop_email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['shop_email']))
                                                        value="{{ $vendorDetails['vendor_business']['shop_email'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">business_license_number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['business_license_number']))
                                                        value="{{ $vendorDetails['vendor_business']['business_license_number'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">address_proof</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['address_proof']))
                                                        value="{{ $vendorDetails['vendor_business']['address_proof'] }}"
                                                        @endif
                                                         readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!empty($vendorDetails['vendor_business']['address_proof_image']))
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image</label>
                                                        <div class="col-sm-9 ">
                                                            <img style="width: 100PX" src="{{ url('admin/images/proofs/' . $vendorDetails['vendor_business']['address_proof_image']) }}" alt="">
                                                            <a target="_blank"
                                                    href="{{ url('admin/images/proofs/' . $vendorDetails['vendor_business']['address_proof_image']) }}">view
                                                    image</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">gst_number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['gst_number']))
                                                        value="{{ $vendorDetails['vendor_business']['gst_number'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">pan_number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_business']['pan_number']))
                                                        value="{{ $vendorDetails['vendor_business']['pan_number'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Bank Information</h4>


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">account_holder_name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_bank']['account_holder_name']))
                                                        value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">bank_name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_bank']['bank_name']))
                                                        value="{{ $vendorDetails['vendor_bank']['bank_name'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">account_number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_bank']['account_number']))
                                                        value="{{ $vendorDetails['vendor_bank']['account_number'] }}"
                                                        @endif

                                                        readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">bank_ifsc_code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                        @if (isset($vendorDetails['vendor_bank']['bank_ifsc_code']))
                                                        value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}"
                                                        @endif
                                                        readonly/>
                                                    </div>
                                                </div>
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
