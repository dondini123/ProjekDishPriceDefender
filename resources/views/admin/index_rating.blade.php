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
         
        </div>
        <div class="card-body">
        
            <table id="datatablesSimple">
                <thead>
                <tr>
                        <th>Username</th>
                        <th>Product Name</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                  
                        <th>Action</th> 
                        <!-- Add other product attributes here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                    <tr>
                        
                        <td>{{ optional($product->user)->username }}</td>
                        <td>{{ optional($product->product)->product_name }}</td>
                        <td>{{ $product->rating }}</td>
                        <td>{{ $product->review }}</td>
                        <td><?php if($product->approve == 0 ){
                            echo "Pending";
                        }else if($product->approve == 1 ){
                            echo "Accepted";
                        }else{
                            echo "Rejected";
                        }
                        ?>
                        </td>
                        <!-- Add other product attributes here -->
                   
                    <td>
                    <form action="/admin/rating/update/{{$product->id}}/1" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')

                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form action="/admin/rating/update/{{$product->id}}/2" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')

                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                    
                    <a href="/admin/rating/show/{{$product -> id}}" class="btn btn-info">Show</a>
                   
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection