@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/home.css" />
@endpush


@push('scripts-dependencies')
<script src="/js/sales_chart.js"></script>
<script src="/js/profits_chart.js"></script>
@endpush


@section('content')

<div class="mx-3">
    @if(session()->has('message'))
    {!! session("message") !!}
    @endif
</div>


@include('/partials/home/home_vendor')



@endsection