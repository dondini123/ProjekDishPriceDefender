@extends('/layouts/auth')

@section('content')



@push('css-dependencies')
<link href="/css/auth.css" rel="stylesheet" />
@endpush


<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ $title }} Page</h1>
                                </div>

                                @if(session()->has('message'))
                                {!! session("message") !!}
                                @endif
                                <p>We will send a password change request in your email so, provide valid email</p>
                                <form class="user" method="post" action="{{route('forget.password.post')}}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                          id="email" name="email" placeholder="Enter an email address">
                                          @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                    <button type="submit" class="btn btn-info btn-block">
                                        Submit
                                    </button>
                                </form>
                                <hr>

                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


@endsection