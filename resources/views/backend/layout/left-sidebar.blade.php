<div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> Admin Panel</a></div>
<div class="sl-sideleft">
  <div class="input-group input-group-search">
    <input type="search" name="search" class="form-control" placeholder="Search">
    <span class="input-group-btn">
      <button class="btn"><i class="fa fa-search"></i></button>
    </span>
  </div>

  <label class="sidebar-label">Navigation</label>
  <div class="sl-sideleft-menu">

    <a href="{{url('/admin/dashboard')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Dashboard</span>
      </div>
    </a>

    <a href="{{route('foods')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Foods</span>
      </div>
    </a>

    <a href="{{route('admin.orders')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Orders</span>
      </div>
    </a>

    <a href="{{route('clients')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Clients</span>
      </div>
    </a>

    <a href="{{route('customers')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Customers</span>
      </div>
    </a>

    <a href="#" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Frontend Settings</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{route('site.settings')}}" class="nav-link">Site Settings</a></li>
      <li class="nav-item"><a href="{{route('terms.conditions')}}" class="nav-link">Terms & Conditions</a></li>
      <li class="nav-item"><a href="{{route('sliders')}}" class="nav-link">Slider</a></li>
      <li class="nav-item"><a href="{{route('abouts')}}" class="nav-link">About</a></li>
    </ul>

    <a href="#" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Reports</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{ route('todays.report') }}" class="nav-link">Todays Report</a></li>
      <li class="nav-item"><a href="{{ route('search.report') }}" class="nav-link">Search Report</a></li>
    </ul>

  </div>

  <br>
</div>