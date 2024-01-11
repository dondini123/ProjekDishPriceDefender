
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
                            <img id="modal-image" src="{{ asset('/' . $data->image) }}" width="70%" class="img-fluid d-block mx-auto" alt="" />
                            <div>
                                <h3>
                                    {{ $data->product_name}}
                                </h3>
                                <div class="content">
                                  
                                    <div class="pembagi"></div>
                                    <div class="price">
                                       Price : {{ $data -> price}}
                                    </div>
                                    <div class="stock">
                                       Stock : {{$data ->stock}}
                                    </div>
                                    <div class="discount">
                                       Discount : {{$data -> discount}}%
                                    </div><br>
                                    <div class="pembagi"></div>
                                    
                                    <div>
                                        <p class="description">
                                           {{ $data->description}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('/product/list')}}"><button class="btn btn-primary btn-xl j mt-4" data-bs-dismiss="modal" type="button"> Back to
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