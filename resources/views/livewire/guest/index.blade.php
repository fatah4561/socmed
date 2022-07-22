@extends('layout.app')
@section('body')

<div class="container-fluid position-relative d-flex p-0">


  <!-- Sidebar Start -->
  <div class="sidebar pe-4 pb-3 ">
    <nav class="navbar bg-secondary navbar-dark ">
        <a href="{{route('dashboard')}}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Socmed</h3>
        </a>
  
        <div class="navbar-nav w-100 ">
          <input wire:model='search' wire:keydown.enter="searchHash" class="nav-item form-control bg-dark border-0 mt-3 ms-2" type="search" placeholder="Search">
            <a href="{{route('dashboard')}}" class="nav-item nav-link {{(Route::current()->getName()=="dashboard")?"active":""}}"><i class="fa fa-tachometer-alt me-2"></i>Home</a>
            <a href="{{route('login')}}" class="nav-item nav-link "><i class="fa fa-sign-in-alt me-2"></i>Login</a>
            
            @yield('nav')
            <hr>
        </div>
    </nav>
  </div>

  <!-- Sidebar End -->


  <!-- Content Start -->
  <div class="content">
      @livewire('guest')
      @yield("content")
  </div>
  <!-- Content End -->


  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
@endsection