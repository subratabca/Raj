<div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> Client Panel</a></div>
<div class="sl-sideleft">
  <div class="input-group input-group-search">
    <input type="search" name="search" class="form-control" placeholder="Search">
    <span class="input-group-btn">
      <button class="btn"><i class="fa fa-search"></i></button>
    </span>
  </div>

  <label class="sidebar-label">Navigation</label>
  <div class="sl-sideleft-menu">

    <a href="{{url('/client/dashboard')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Dashboard</span>
      </div>
    </a>

    <a href="{{route('client.foods')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Foods</span>
      </div>
    </a>

    <a href="{{route('client.orders')}}" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Orders</span>
      </div>
    </a>

    <a href="#" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Terms & Conditions</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{ url('/client/terms-conditions/food_upload') }}" class="nav-link">Food Upload</a></li>
      <li class="nav-item"><a href="{{ url('/client/terms-conditions/request_approve') }}" class="nav-link">Request Approve</a></li>
      <li class="nav-item"><a href="{{ url('/client/terms-conditions/food_deliver') }}" class="nav-link">Food Deliver</a></li>
    </ul>

    <a href="#" class="sl-menu-link">
      <div class="sl-menu-item">
        <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
        <span class="menu-item-label">Reports</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{ route('client.todays.report') }}" class="nav-link">Todays Report</a></li>
      <li class="nav-item"><a href="{{ route('client.search.report') }}" class="nav-link">Search Report</a></li>
    </ul>

  </div>

  <br>
</div>