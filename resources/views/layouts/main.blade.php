<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }} Page</title>
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
  @include('/partials/main_css')
  @stack('css-dependencies')
</head>

<body class="sb-nav-fixed">
  <div id="loading" style="display: none"></div>
  {{-- topbar --}}
  @include('/partials/topbar')
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      {{-- sidebar --}}
      @if(auth()->check())
        @if(auth()->user()->role == 1)
          {{-- Role 1 Sidebar --}}
          @include('/partials/user_sidebar')
        @elseif(auth()->user()->role == 2)
          {{-- Role 2 Sidebar --}}
          @include('/partials/vendor_sidebar')
        @elseif(auth()->user()->role == 3)
          {{-- Role 3 Sidebar --}}
          @include('/partials/sidebar')
        @endif
      @endif
    </div>
    <div id="layoutSidenav_content">
      {{-- content --}}
      @yield("content")
      {{-- footer --}}
      @include('/partials/footer')
    </div>
  </div>

  @stack('modals-dependencies')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="../public/js/datatables-simple.js"></script>

  <script src="../public/js/scripts.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @stack('scripts-dependencies')
</body>

</html>