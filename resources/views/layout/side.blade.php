{{-- <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    <span class="fs-4">Sidebar</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
  </ul>
  <hr>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
      <strong>mdo</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
      <li><a class="dropdown-item" href="#">New project...</a></li>
      <li><a class="dropdown-item" href="#">Settings</a></li>
      <li><a class="dropdown-item" href="#">Profile</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">Sign out</a></li>
    </ul>
  </div>
</div> --}}

<div class="sidebar pe-4 pb-3 ">
  <nav class="navbar bg-secondary navbar-dark ">
      <a href="{{route('dashboard')}}" class="navbar-brand mx-4 mb-3">
          <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Socmed</h3>
      </a>

      <div class="navbar-nav w-100 ">
          <a href="{{route('dashboard')}}" class="nav-item nav-link {{(Route::current()->getName()=="dashboard")?"active":""}}"><i class="fa fa-tachometer-alt me-2"></i>Home</a>
          <input wire:model='search' wire:keydown.enter="searchHash" class="nav-item form-control bg-dark border-0 mt-3 ms-2" type="search" placeholder="Search">
          
          @yield('nav')
          <hr>
          <div class="nav-item dropdown ">
              <a href="#" class="nav-link  dropdown-toggle {{(Route::current()->getName()=="profile")?"active show":""}}" data-bs-toggle="dropdown">            
                <img class="rounded-circle me-2" src="{{Storage::url(Auth::user()->profile_pic)}}?{{ rand() }}" alt="" style="width: 40px; height: 40px;">  {{Auth::user()->name}}</a>
                <div class="dropdown-menu bg-transparent border-0 ms-5 {{(Route::current()->getName()=="profile")?"active show":""}}">
                  <a href="{{route('profile', Auth::user()->id)}}" class="dropdown-item">Profile</a>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fa fa-sign-out"></i>Signout</button>
                  </form>
              </div>
          </div>
      </div>
  </nav>
</div>