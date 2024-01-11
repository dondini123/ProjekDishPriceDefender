
@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/product.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/product.js" type="module"></script>
@endpush

@push('modals-dependencies')
@include('/partials/product/product_detail_modal')
@endpush

@section('content')

<!-- Product Detail Modal -->
<div class="program-modal " id="ProductDetailModal">
    <div class="modal-dialog" style="margin:0; padding-top:0">
        <div class="modal-content" style="margin:0; padding-top:0">
            
            
            <div class="container" style="margin:0; padding-top:0">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="modal-body">
                            <!-- Product details-->
                            <h2 class="text-uppercase">
                            </h2>
                            <br>
                            <p class="orientasi text-center">
                                <!-- Orientation -->
                            </p>
                            <img id="modal-image" style="border-radius: 180%;" src="{{ asset('storage/' . $data->image) }}" width="200px" height="200px" class="img-fluid d-block mx-auto" alt="" />
                            <div>
                                <h6>
                                    {{ $data->username}}
                                </h6>
                                <div class="content">
                                  
                                
                                    <div class="price">
                                       Email : {{ $data -> email}}
                                    </div>
                                    <div class="stock">
                                       Gender : @if($data ->gender == "M") 
                                                    Male
                                                @else 
                                                     Female
                                                @endif
                                    </div>
                                    <div class="discount">
                                       Phone : {{$data -> phone}}
                                    </div>
                                    
                                    
                                    <div>
                                        <p class="description">
                                          Role : @if($data ->role == "1") 
                                                    Customer
                                                @elseif($data -> role == "2") 
                                                     Vendor
                                                @else 
                                                    Admin
                                                 @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('/home/customers')}}"><button class="btn btn-primary btn-xl j mt-4" data-bs-dismiss="modal" type="button"> Back to
                                Product List</button></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Product Detail Modal -->
@endsection