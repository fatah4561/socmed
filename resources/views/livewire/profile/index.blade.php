@extends('layout.app')
@section('body')

<div class="container-fluid position-relative d-flex p-0">


  <!-- Sidebar Start -->
    @include('layout.side')

  <!-- Sidebar End -->


  <!-- Content Start -->
  <div class="content">
      @yield("content")
  </div>
  <!-- Content End -->


  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
@endsection