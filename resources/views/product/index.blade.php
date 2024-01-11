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
<!-- product -->
<section id="product" class="pb-5">
    <div class="container">

        @if(session()->has('message'))
        {!! session("message") !!}
        @endif

        <h5 class="section-title h1">Shop</h5>
        @can('add_product',App\Models\Product::class)
        <div class="d-flex align-items-end flex-column mb-4">
            <a style="text-decoration: none;" href="/product/add_product">
                <div class="text-right button-kemren mr-lg-5 mr-sm-3">pe</div>
            </a>
        </div>
        @else
        <div class="mb-5"></div>
        @endcan

        <div class="row justify-content-center">
            @foreach($product as $row)
            <!-- Product card -->
            <div class="col-xs-12 col-sm-6 col-md-4">
               
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('/' . $row->image) }}"
                                          alt="Product Name"></p>
                                    <h4 class="card-title">{{ $row->username }}</h4>
                                    
                                    <a href="/product/items/{{ $row->id}}"><button 
                                      class="btn btn-primary ">Product</button></a>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                
            </div>
            <!-- ./product card -->
            @endforeach
        </div>
    </div>
</section>
<!-- product -->

@endsection