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
                        <th>Product Name</th>
                        <th>Total Product</th>
                        <th>Total Rating</th>
                        <th>Phone </th>
                        <th>Generate Report </th>
                  
                      
                        <!-- Add other product attributes here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $product)
                    <tr>
                        <td>{{ $product['username'] }}</td>
                        <td>{{ $product['product_count'] }}</td>
                        <td>{{ $product['average_rating'] }}</td>
                        <td>{{ $product['phone'] }}</td>
                        <td> 
                        <form action="{{ route('generate_report', ['userId' => $product['id']]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Generate PDF</button>
                            </form>
                        </td>
                        <!-- Add other product attributes here -->
                   
                   
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection