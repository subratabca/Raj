<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
    <aside class="sidebar">
        <!--Sidebar Widget / Styled Nav-->
        <div class="widget sidebar-widget styled-nav">
            <nav class="nav-outer">
                <ul>
                    <li class="{{ Route::is('user.dashboard') ? 'current' : '' }}"><a href="{{ route('user.dashboard') }}"><i class="fa fa-link" aria-hidden="true"></i>Dashboard</a></li>
                    <li class="{{ Route::is('orders') ? 'current' : '' }}"><a href="{{ route('orders') }}"><i class="fa fa-link" aria-hidden="true"></i>My Order</a></li>
                    <li class="{{ Route::is('user.profile') ? 'current' : '' }}"><a href="{{ route('user.profile') }}"><i class="fa fa-link" aria-hidden="true"></i>Update Profile</a></li>
                    <li class="{{ Route::is('user.update.password') ? 'current' : '' }}"><a href="{{ route('user.update.password') }}"><i class="fa fa-link" aria-hidden="true"></i>Update Password</a></li>
                    <li><a href="{{ route('logout') }}"><i class="fa fa-link" aria-hidden="true"></i>Logout</a></li>
                </ul>
            </nav>
        </div>

    </aside>
</div>


