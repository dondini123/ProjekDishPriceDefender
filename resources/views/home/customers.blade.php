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
    @if(session()->has('message'))
                                {!! session("message") !!}
                                @endif

    <!-- inisial value -->
    <input type="hidden" name="username" id="username" value="{{ (isset($_GET['username'])) ? $_GET['username']
          : '' }}">

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-fw fa-solid fa-users me-1"></i>
            Customers
           
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                      
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>                
                        <th>Phone</th>
                        <th>Action</th>
                       
                      
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $row)
                    <tr>
                    
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->role == "1" ? "User" : ($row->role == "2" ? "Vendor" : "Admin") }}</td>
                        <td>{{ $row->phone }}</td>
                        <td >   
                    <a href="/customers/edit/{{$row->id}}" class="btn btn-primary">Edit</a>
                    <a href="/customer/show/{{$row->id}}" class="btn btn-info">Show</a>
                    <form action="/customer/delete/{{$row->id}}" method="POST" style="display:inline;">
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