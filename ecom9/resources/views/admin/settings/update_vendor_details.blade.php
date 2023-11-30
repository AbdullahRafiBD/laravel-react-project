@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Update Vendor Details</h3>
                            {{-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> --}}
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="justify-content-end d-flex">
                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                        id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                        <a class="dropdown-item" href="#">January - March</a>
                                        <a class="dropdown-item" href="#">March - June</a>
                                        <a class="dropdown-item" href="#">June - August</a>
                                        <a class="dropdown-item" href="#">August - November</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($slug == 'personal')
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Personal Details</h4>
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
                                <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}"
                                    method="POST" enctype="multipart/form-data">@csrf
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Vendor Username</label>
                                        <input type="text" class="form-control"
                                            value="{{ Auth::guard('admin')->user()->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Vendor Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ Auth::guard('admin')->user()->email }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Type</label>
                                        <input type="email" class="form-control"
                                            value="{{ Auth::guard('admin')->user()->type }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_name">Name</label>
                                        <input type="text" class="form-control" id="vendor_name" name="vendor_name"
                                            value="{{ Auth::guard('admin')->user()->name }}" placeholder="Enter Admin Name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_mobile">Mobile</label>
                                        <input type="text" class="form-control" id="vendor_mobile" name="vendor_mobile"
                                            value="{{ Auth::guard('admin')->user()->mobile }}"
                                            placeholder="Enter Admin Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_address">address</label>
                                        <input type="text" class="form-control" id="vendor_address" name="vendor_address"
                                            value="{{ $vendorDetails['address'] }}" placeholder="Enter New Password"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_city">city</label>
                                        <input type="text" class="form-control" id="vendor_city" name="vendor_city"
                                            value="{{ $vendorDetails['city'] }}" placeholder="Enter New Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_state">state</label>
                                        <input type="text" class="form-control" id="vendor_state" name="vendor_state"
                                            value="{{ $vendorDetails['state'] }}" placeholder="Enter New Password"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_country">country</label>
                                        {{-- <input type="text" class="form-control" id="vendor_country"
                                            name="vendor_country" value="{{ $vendorDetails['country'] }}"
                                            placeholder="Enter New Password" required> --}}
                                        <select class="form-control"id="vendor_country" name="vendor_country">
                                            <option value="">Select</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country['country_name']}}" @if ($country['country_name']==$vendorDetails['country'])
                                                selected
                                            @endif>{{$country['country_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_pincode">pincode</label>
                                        <input type="text" class="form-control" id="vendor_pincode"
                                            name="vendor_pincode" value="{{ $vendorDetails['pincode'] }}"
                                            placeholder="Enter New Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_image">Vendor photo</label>
                                        <input type="file" class="form-control" id="vendor_image"
                                            name="vendor_image">
                                        @if (!empty(Auth::guard('admin')->user()->image))
                                            <a target="_blank"
                                                href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">view
                                                image</a>
                                            <input type="hidden" name="current_vendor_image"
                                                value="{{ Auth::guard('admin')->user()->image }}">
                                        @endif
                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @elseif($slug == 'business')
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Business Details</h4>
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
                                <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}"
                                    method="POST" enctype="multipart/form-data">@csrf
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Vendor Username</label>
                                        <input type="text" class="form-control"
                                            value="{{ Auth::guard('admin')->user()->name }}" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label for="shop_name">shop_name</label>
                                        <input type="text" class="form-control" id="shop_name" name="shop_name"
                                        @if (isset($vendorDetails['shop_name']))
                                        value="{{ $vendorDetails['shop_name'] }}"
                                        @endif
                                        placeholder="shop_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_address">shop_address</label>
                                        <input type="text" class="form-control" id="shop_address" name="shop_address"
                                        @if (isset($vendorDetails['shop_address']))
                                        value="{{ $vendorDetails['shop_address'] }}"
                                        @endif
                                             placeholder="shop_address"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_city">shop_city</label>
                                        <input type="text" class="form-control" id="shop_city" name="shop_city"
                                        @if (isset($vendorDetails['shop_city']))
                                        value="{{ $vendorDetails['shop_city'] }}"
                                        @endif
                                             placeholder="shop_city" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_state">shop_state</label>
                                        <input type="text" class="form-control" id="shop_state" name="shop_state"
                                        @if (isset($vendorDetails['shop_state']))
                                        value="{{ $vendorDetails['shop_state'] }}"
                                        @endif
                                             placeholder="shop_state" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_country">shop_country</label>
                                        {{-- <input type="text" class="form-control" id="shop_country" name="shop_country"
                                            value="{{ $vendorDetails['shop_country'] }}" placeholder="shop_country"
                                            required> --}}
                                        <select class="form-control" id="shop_country" name="shop_country">
                                            <option value="">Select</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country['country_name']}}" @if (isset($vendorDetails['shop_country']) && $country['country_name']==$vendorDetails['shop_country'])
                                                selected
                                            @endif>{{$country['country_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_pincode">shop_pincode</label>
                                        <input type="text" class="form-control" id="shop_pincode" name="shop_pincode"
                                        @if (isset($vendorDetails['shop_pincode']))
                                        value="{{ $vendorDetails['shop_pincode'] }}"
                                        @endif
                                             placeholder="shop_pincode"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_mobile">shop_mobile</label>
                                        <input type="text" class="form-control" id="shop_mobile" name="shop_mobile"
                                        @if (isset($vendorDetails['shop_mobile']))
                                        value="{{ $vendorDetails['shop_mobile'] }}"
                                        @endif
                                            placeholder="shop_mobile"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_website">shop_website</label>
                                        <input type="text" class="form-control" id="shop_website" name="shop_website"
                                        @if (isset($vendorDetails['shop_website']))
                                        value="{{ $vendorDetails['shop_website'] }}"
                                        @endif
                                            placeholder="shop_website"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_email">shop_email</label>
                                        <input type="text" class="form-control" id="shop_email" name="shop_email"
                                        @if (isset($vendorDetails['shop_email']))
                                        value="{{ $vendorDetails['shop_email'] }}"
                                        @endif
                                            placeholder="shop_email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_proof">address_proof</label>
                                        <select class="form-control" name="address_proof" id="address_proof">
                                            <option value="Passport" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=='Passport')
                                                selected
                                            @endif>Passport</option>
                                            <option value="NID" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=='NID')
                                            selected
                                        @endif>NID</option>
                                            <option value="Driving License" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=='Driving License')
                                            selected
                                        @endif>Driving License</option>
                                            <option value="Tax Certificate" @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=='Tax Certificate')
                                            selected
                                        @endif>Tax Certificate</option>
                                        </select>

                                        {{-- <input type="text" class="form-control" id="address_proof" name="address_proof" value="{{$vendorDetails['address_proof']}}" placeholder="address_proof" required> --}}
                                    </div>
                                    <div class="form-group">
                                      <label for="address_proof_image">address_proof_image</label>
                                      <input type="file" class="form-control" id="address_proof_image"
                                          name="address_proof_image">
                                      @if (!empty($vendorDetails['address_proof_image']))
                                          <a target="_blank"
                                              href="{{ url('admin/images/proofs/' . $vendorDetails['address_proof_image']) }}">view
                                              image</a>
                                          <input type="hidden" name="current_address_proof_image"
                                              value="{{ $vendorDetails['address_proof_image'] }}">
                                      @endif
                                  </div>
                                    <div class="form-group">
                                        <label for="business_license_number">business_license_number</label>
                                        <input type="text" class="form-control" id="business_license_number"
                                            name="business_license_number"
                                            @if (isset($vendorDetails['business_license_number']))
                                        value="{{ $vendorDetails['business_license_number'] }}"
                                        @endif
                                            placeholder="business_license_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="gst_number">gst_number</label>
                                        <input type="text" class="form-control" id="gst_number" name="gst_number"
                                        @if (isset($vendorDetails['gst_number']))
                                        value="{{ $vendorDetails['gst_number'] }}"
                                        @endif
                                           placeholder="gst_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan_number">pan_number</label>
                                        <input type="text" class="form-control" id="pan_number" name="pan_number"
                                        @if (isset($vendorDetails['pan_number']))
                                        value="{{ $vendorDetails['pan_number'] }}"
                                        @endif
                                            placeholder="pan_number" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($slug == 'bank')
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Update Bank Details</h4>
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
                          <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}"
                              method="POST" enctype="multipart/form-data">@csrf
                              <div class="form-group">
                                  <label for="exampleInputUsername1">Vendor Username</label>
                                  <input type="text" class="form-control"
                                      value="{{ Auth::guard('admin')->user()->name }}" readonly>
                              </div>

                              <div class="form-group">
                                  <label for="account_holder_name">account_holder_name</label>
                                  <input type="text" class="form-control" id="account_holder_name" name="account_holder_name"
                                  @if (isset($vendorDetails['account_holder_name']))
                                        value="{{ $vendorDetails['account_holder_name'] }}"
                                        @endif
                                      placeholder="account_holder_name"
                                      required>
                              </div>
                              <div class="form-group">
                                  <label for="bank_name">bank_name</label>
                                  <input type="text" class="form-control" id="bank_name" name="bank_name"
                                  @if (isset($vendorDetails['bank_name']))
                                        value="{{ $vendorDetails['bank_name'] }}"
                                        @endif
                                      placeholder="bank_name" required>
                              </div>
                              <div class="form-group">
                                  <label for="account_number">account_number</label>
                                  <input type="text" class="form-control" id="account_number" name="account_number"
                                  @if (isset($vendorDetails['account_number']))
                                        value="{{ $vendorDetails['account_number'] }}"
                                        @endif
                                      placeholder="account_number" required>
                              </div>
                              <div class="form-group">
                                  <label for="bank_ifsc_code">bank_ifsc_code</label>
                                  <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code"
                                  @if (isset($vendorDetails['bank_ifsc_code']))
                                        value="{{ $vendorDetails['bank_ifsc_code'] }}"
                                        @endif
                                      placeholder="bank_ifsc_code"
                                      required>
                              </div>



                              <button type="submit" class="btn btn-primary mr-2">Submit</button>
                              <button class="btn btn-light">Cancel</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
            @endif



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
