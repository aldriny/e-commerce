<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{asset('storage/images')}}/logo.png" alt="Logo">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <!-- ***** Search Input ***** -->
                        <li class="nav-item search-bar">
                            <form action="{{ route('search') }}" method="GET" class="d-inline">
                                <input type="text" name="search" class="form-control" placeholder="Search..." required maxlength="255" style="display: inline; width: auto; max-width: 200px;">
                            </form>
                        </li>                        
                        <li class="scroll-to-section">
                            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
                        </li>
                        <li class="scroll-to-section">
                            <a href="{{ route('products.index') }}" class="{{ Request::is('products*') ? 'active' : '' }}">Products</a>
                        </li>
                        <li class="scroll-to-section">
                            <a href="{{ route('categories.index') }}" class="{{ Request::is('categories*') ? 'active' : '' }}">Categories</a>
                        </li>
                        <!-- Language Switch -->
                        <li class="submenu">
                            <a href="#">Language</a>
                            <ul>
                                <li><a href="{{ route('lang.switch', 'en') }}">English</a></li>
                                <li><a href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                            </ul>
                        </li>

                        @auth
                        <li class="scroll-to-section">
                            <a href="{{ route('favourites.index') }}">
                                <i class="fa fa-heart" style="font-size: 1.4em;"></i>
                                @if(Session::has('favourites') && count(Session::get('favourites')) > 0)
                                    <span class="badge badge-pill badge-danger">{{ count(Session::get('favourites')) }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <!-- Cart Icon -->
                        <li class="scroll-to-section">
                            <a href="{{ route('cart.index') }}">
                                <i class="fa fa-shopping-cart" style="font-size: 1.4em;"></i>
                                @if(Session::has('cart') && count(Session::get('cart')) > 0)
                                    <span class="badge badge-pill badge-danger">{{ count(Session::get('cart')) }}</span>
                                @endif
                            </a>
                        </li>
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            <li class="scroll-to-section">
                                <a href="{{ route('login') }}" class="{{ Request::is('login') ? 'active' : '' }}">Login</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="{{ route('register') }}" class="{{ Request::is('register') ? 'active' : '' }}">Sign Up</a>
                            </li>
                        @else
                            <li class="scroll-to-section">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest

                    </ul>        
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
