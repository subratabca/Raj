
        <header class="site-header headersecond">
            <!-- Header Top -->
            <div class="header-top">
                <div class="container clearfix">
                    <!--Top Left-->
                    <div class="top-left pull-left">
                        <ul class="links-nav clearfix">
                            <li><a href="#"><span class="fa fa-map-marker"></span><span id="address"></span></a></li>
                            <li><a href="#"><span class="fa fa-phone"></span><span id="phone"></span></a></li>
                            <li><a href="#"><span class="fa fa-envelope-o"></span><span id="email"></span></a></li>
                        </ul>
                    </div>
                    <!--Top Right-->
                    <div class="top-right pull-right">
                        <a href="contact.html" class="theme-btn quote-btn"><i class="fa fa-share"></i> Get a Quote</a>
                    </div>
                    <!--Top Right-->
                    <div class="top-right pull-right">
                        <div class="social-links clearfix">
                            <a href="#"><span class="fa fa-facebook-f"></span></a>
                            <a href="#"><span class="fa fa-google-plus"></span></a>
                            <a href="#"><span class="fa fa-twitter"></span></a>
                            <a href="#"><span class="fa fa-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Top End -->

            <!--Header-Main-->
            <div class="header-main">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="logo">
                               <a href="{{ route('home') }}"><img src="" alt="logo" id="logo"></a>
                            </div>
                        </div>
                        <div class="col-sm-9">

                            <!-- Seach box -->
                            <ul class="menusearch">
                                <li>
                                    <div class="bz_search_bar" >
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </div>
                                    <div   class="bz_search_box" style="display: none;">
                                        <input placeholder="Search here" type="text">
                                        <button><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                            </ul>
                            <!-- Seach box end -->

                            <!-- Main Menu -->
                            <nav class="main-menu">
                                <div class="navbar-header">
                                    <!-- Toggle Button -->
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

<div class="navbar-collapse collapse clearfix">
    <ul class="navigation clearfix">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('contact.us.page') }}">Contact Us</a></li>

        @if(Cookie::get('token') !== null)
        <li class="dropdown">
            <a href=""><i class="fa fa-bell"></i><span class="badge badge-pill badge-danger" id="notificationCount">5</span></a>
            <ul class="notification-list">

            </ul>
        </li>
        <li class="dropdown">
            <a href="#" id="login-user-name">Account</a>
            <ul>
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
        @else
        <li id="login-link"><a href="{{ route('login.page') }}">Login</a></li>
        @endif
    </ul>
</div>


                            </nav>
                            <!-- Main Menu end -->

                        </div>
                    </div>
                </div>
            </div>

            <!--Sticky Header-->
            <div class="sticky-header">
                <div class="auto-container clearfix">
                    <!--Logo-->
                    <div class="logo pull-left">
                        <a href="{{ route('home') }}" class="img-responsive"><img src="" alt="logo" id="logo2"></a>
                    </div>

                    <!--Right Col-->
                    <div class="right-col pull-right">

                        <!-- Seach box -->
                        <ul class="menusearch">
                            <li>
                                <div class="bz_search_bar" >
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                                <div class="bz_search_box" style="display: none;">
                                    <input placeholder="Search here" type="text">
                                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </li>
                        </ul>
                        <!-- Seach box end -->

                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-header">
                                <!-- Toggle Button -->
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

<div class="navbar-collapse collapse clearfix">
    <ul class="navigation clearfix">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('contact.us.page') }}">Contact Us</a></li>

        @if(Cookie::get('token') !== null)
        <li class="dropdown">
            <a href=""><i class="fa fa-bell"></i><span class="badge badge-pill badge-danger" id="notificationCount">5</span></a>
            <ul class="notification-list">

            </ul>
        </li>
        <li class="dropdown">
            <a href="#" id="login-user-name">Account</a>
            <ul>
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
        @else
        <li id="login-link"><a href="{{ route('login.page') }}">Login</a></li>
        @endif
    </ul>
</div>
                        </nav>
                        <!-- Main Menu End-->
                    </div>

                </div>
            </div>
            <!--End Sticky Header-->

        </header>

@if(Cookie::get('token') !== null)
<script>
document.addEventListener("DOMContentLoaded", async function () {
    try {
        const response = await axios.get('/user/notification/info');

        if (response.status === 200) {
            const userData = response.data.data;
            const unreadNotifications = response.data.unreadNotifications;
            const readNotifications = response.data.readNotifications;

            document.getElementById('login-user-name').innerText = userData.firstName || 'Account';
            document.getElementById('notificationCount').innerText = unreadNotifications.length;

            displayNotifications(unreadNotifications, readNotifications);
        }
    } catch (error) {
        if (error.response) {
            const status = error.response.status;
            const message = error.response.data.message || 'An unexpected error occurred';

            if (status === 400) {
                errorToast(message || 'Bad Request');
            } else if (status === 404) {
                errorToast(message || 'Not Found');
            } else if (status === 500) {
                errorToast(message || 'Server Error');
            } else {
                errorToast(message);
            }
        } else if (error.request) {
            errorToast('No response received from the server.');
        } else {
            errorToast('Error: ' + error.message);
        }
    }


    function displayNotifications(unreadNotifications, readNotifications) {
        const notificationsContainer = document.querySelector('.notification-list');
        let notificationsHTML = '';

        if ((unreadNotifications && unreadNotifications.length === 0) &&
            (readNotifications && readNotifications.length === 0)) {
            notificationsContainer.innerHTML = '<li>No notifications</li>';
            return;
        }

        if (unreadNotifications && unreadNotifications.length > 0) {
            unreadNotifications.forEach(notification => {
                notificationsHTML += `
                    <li>
                        <a href="/user/markAsRead/notification/${notification.id}">
                            <strong>${notification.data.data}</strong><br>
                            <span>${new Date(notification.created_at).toLocaleString()}</span><br>
                        </a>
                        <button class="delete-notification-btn btn btn-danger btn-block" onclick="deleteNotification(${notification.id})">Delete</button>
                        
                    </li><hr>`;
            });
        }

        if (readNotifications && readNotifications.length > 0) {
            readNotifications.forEach(notification => {
                notificationsHTML += `
                    <li>
                        <a href="/user/markAsRead/notification/${notification.id}">
                            <span style="color: #adb5bd;">${notification.data.data}<br>
                            ${new Date(notification.created_at).toLocaleString()}</span><br>
                        </a>
                        <button class="delete-notification-btn btn btn-danger btn-block" onclick="deleteNotification(${notification.id})">Delete</button>
                    </li>`;
            });
        }

        notificationsContainer.innerHTML = notificationsHTML;
    }

    async function deleteNotification(notificationId) {
        try {
            const response = await axios.get(`/user/delete/notification/${notificationId}`);

            if (response.status === 200) {
                successToast(response.data.message || 'Request success');
                window.location.reload();
            } else {
                errorToast(response.data.message || 'Failed to delete notification');
            }
        } catch (error) {
            if (error.response) {
                const status = error.response.status;
                const message = error.response.data.message || 'An unexpected error occurred';

                if (status === 404 && error.response.data.status === 'failed to fetch user') {
                    errorToast(message || 'User not found');
                } else if (status === 404 && error.response.data.status === 'failed') {
                    errorToast(message || 'Notification not found');
                } else if (status === 500) {
                    errorToast(message || 'Server Error');
                } else {
                    errorToast(message);
                }
            } else if (error.request) {
                errorToast('No response received from the server.');
            } else {
                errorToast('Error: ' + error.message);
            }
        }
    }

});

</script>


@endif