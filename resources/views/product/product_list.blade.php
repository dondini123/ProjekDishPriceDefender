@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/customers_table.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endpush

@section('content')

<div class="container-fluid mt-4 px-3">

    @include('/partials/breadcumb')

    <!-- inisial value -->
    <input type="hidden" name="username" id="username" value="{{ (isset($_GET['username'])) ? $_GET['username']
          : '' }}">

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-fw fa-solid fa-users me-1"></i>
           Product 
            <a style="float:right" href="/product/add_product" class="btn btn-primary">Add</a>
        </div>
        <div class="card-body">
        
            <table id="datatablesSimple">
                <thead>
                <tr>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Orientation</th>
                        <th>Description</th>
                        <th>Action</th> 
                        <!-- Add other product attributes here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userProducts as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td>{{ $product->orientation }}</td>
                        <td>{{ $product->description }}</td>
                        <!-- Add other product attributes here -->
                   
                    <td>
                    <a href="{{ route('product.edit_product', $product->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('product.show_product' , $product->id)}}" class="btn btn-info">Show</a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection