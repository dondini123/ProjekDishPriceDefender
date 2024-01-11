@extends('/layouts/main')

@push('css-dependencies')
<link href="/css/profile.css" rel="stylesheet" />
@endpush

@push('scripts-dependencies')
<script src="/js/profile.js" type="module"></script>
@endpush

@section('content')
<div class="main-body px-1 px-md-3 px-lg-4 px-xl-5">

    @include('/partials/breadcumb')

    <!-- flasher -->
    @if(session()->has('message'))
    {!! session("message") !!}
    @endif

    <div class="row">
    
        <div class="col-xl-11">
            <!-- Profile details card-->
            <div class="card mb-4">
                <div class="card-header">Customer Details</div>
                <div class="card-body">
                    <!-- Form Group (username)-->
                    <form method="post" action="/customer/post/{{ $data->id }}"
                      enctype="multipart/form-data">
                      @csrf
                    <div class="mb-3">
                        <label class="small mb-1" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="text"
                          placeholder="Enter your email address" value="{{$data->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="username">Username <em class="link-danger">will show as your
                                identity in the website</em></label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username"
                          name="username" type="text" placeholder="your username"
                          value="{{ $data->username }}" required>
                        @error('username')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="fullname">Full Name</label>
                        <input class="form-control @error('fullname') is-invalid @enderror" id="fullname"
                          name="fullname" type="text" placeholder="your fullname"
                          value="{{ $data->fullname }}" required>
                        @error('fullname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="phone">No. HP</label>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                              type="text" placeholder="your phone" value="{{$data->phone }}" required>
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="gender">Gender</label>
                            <input class="form-control" id="gender" name="gender" type="text"
                              value="{{ $data->gender == " M" ? "Male" : "Female" }}"" readonly>
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                    <select class="form-control" id="role" name="gender">
                        <option value="customer" {{$data->role == '1' ? 'selected' : '' }}>Customer</option>
                        <option value="vendor" {{ $data->role == '2' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ (!$data->role == '1' || $data->role == '2')? 'selected' : '' }}>Admin</option>
                    </select>

                                            
                          
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="name" class="col-sm-12 col-form-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                              name="address" placeholder="Please enter your location"
                              value="{{ $data->address }}" required>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Save changes button-->
                    <div class="col-12 d-flex justify-content-start align-items-center">
                        <a href="/home/customers" class="btn btn-outline-secondary me-2">Back</a>
                        <button class="btn btn-dark" type="submit">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection