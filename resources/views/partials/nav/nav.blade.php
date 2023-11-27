    @include('partials.header')

    <nav class="navbar navbar-expand-lg sticky-top" id="custom-navbar">
        <div class="container-fluid">
            <!-- Logo--> 
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/kpj logo.png') }}" alt="Logo" width="100" height="50" class="d-inline-block align-text-top">
            </a>
            <!-- System name -->
            <a class="navbar-brand fw-bold text-light" href="{{ Auth::check() ? route(Auth::user()->position . '.home') : '/' }}">Training System</a>
            
            @auth
                @if(Auth()->user()->position === 'hos')
                    @include('partials.nav.hos')
                @endif

                @if(Auth()->user()->position === 'admin')
                    @include('partials.nav.admin')
                @endif

                @if(Auth()->user()->position === 'ITadmin')
                    @include('partials.nav.ITadmin')
                @endif

                @if(Auth()->user()->position === 'staff')
                    @include('partials.nav.staff')
                @endif

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex ms-auto">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="dropdown-item">
                                <a href="{{ route(Auth()->user()->position . '.home') }}" style="text-decoration: none; color: inherit;">
                                    <i class="bi bi-house icon-lg mx-2"></i>
                                </a>
                            </li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right icon-lg mx-2"></i>
                                </button>
                            </form>
                        </ul>
                    </div>
                </div>

            @endauth
        </div>
    </nav>
