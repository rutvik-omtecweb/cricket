<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav first-li">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto sec-li">
        <!-- Navbar Search -->
        <li class="nav-item search">
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item dropdown user-menu">

            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img @if (Auth::user()->image) src="{{ Auth::user()->image }}"
                @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                    alt="Your Slider Image" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline" style="text-transform: capitalize">{{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img @if (Auth::user()->image) src="{{ Auth::user()->image }}"
                    @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                        onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'"
                        class="img-circle elevation-2" alt="User Image">
                    <p style="text-transform: capitalize">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        <small></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                    <a class="btn btn-default btn-flat float-right"href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
