<div class="sl-header">
  <div class="sl-header-left">
    <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
    <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
  </div><!-- sl-header-left -->
  <div class="sl-header-right">
    <nav class="nav">
      <div class="dropdown">
        <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
          <span class="logged-name" id="userName">Uer Name</span>
          <img src="../img/img3.jpg" id="admin-header-img" class="wd-32 rounded-circle" alt="">
        </a>
        <div class="dropdown-menu dropdown-menu-header wd-200">
          <ul class="list-unstyled user-profile-nav">
            <li><a href="{{ url('/admin/update/profile') }}"><i class="icon ion-ios-person-outline"></i>Update Profile</a></li>
            <li><a href="{{ url('/admin/update/password') }}"><i class="icon ion-ios-star-outline"></i>Update Password</a></li>
            <li><a href="{{ route('admin.logout') }}"><i class="icon ion-power"></i> Sign Out</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="navicon-right">
      <a id="btnRightMenu" href="" class="pos-relative">
        <i class="icon ion-ios-bell-outline"></i>
        <span class="square-8 bg-danger" id="notificationCount"> </span>
      </a>
    </div>
  </div>
</div>


