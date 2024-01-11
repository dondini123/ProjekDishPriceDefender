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

        <h5 class="section-title h1">Rating</h5>

        <div class="row justify-content-center">
            
            <!-- Product card -->
            <div class="col-xs-12 col-sm-6 col-md-4">
               
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Username : {{ optional($data->user)->username ?? 'null'  }}</h4>
                                    <p class="card-text">Porduct Name : {{ optional($data->product)->product_name ?? 'null'  }}</p>
                                    <p class="card-text">Rating : {{ $data->rating }}</p>
                                    <p class="card-text">Review : {{ $data->review }}</p>
                                    <p class="card-text">Status :<?php if($data->approve == 0 ){
                            echo "Pending";
                        }else if($data->approve == 1 ){
                            echo "Accepted";
                        }else{
                            echo "Rejected";
                        }
                        ?></p>
                                    <p class="card-text">{{ $data->created_at }}</p>
                                  

                                    <a href="/admin/rating/index"><button 
                                      class="btn btn-primary ">Back</button></a>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                
            </div>
            <!-- ./product card -->
         
        </div>
    </div>
</section>
<!-- product -->

@endsection