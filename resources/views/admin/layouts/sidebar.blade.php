<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo text-decoration-none text-light" href={{route('home')}}>@lang('messages.dashboard')</a>
        <a class="sidebar-brand brand-logo-mini text-decoration-none text-light navbar-mini-logo" href={{route('home')}}>@lang('messages.dashboard_mini')</a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="/storage/users/{{ Auth::user()->image }}" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('profile.show') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-face-profile"></i>
                </span>
                <span class="menu-title">@lang('messages.profile')</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#categories_dropdown" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">@lang('messages.categories')</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="categories_dropdown">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.categories.index') }}">@lang('messages.all_categories')</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.categories.create') }}">@lang('messages.create_category')</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#products_dropdown" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">@lang('messages.products')</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="products_dropdown">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.products.index') }}">@lang('messages.all_products')</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.products.create') }}">@lang('messages.create_product')</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
