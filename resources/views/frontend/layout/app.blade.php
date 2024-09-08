<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- Stylesheets -->
    <!-- bootstrap v3.3.6 css -->
    <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
    <!-- font-awesome css -->
    <link href="{{ asset('frontend/css/font-awesome.css') }}" rel="stylesheet">
    <!-- flaticon css -->
    <link href="{{ asset('frontend/css/flaticon.css') }}" rel="stylesheet">
    <!-- animate css -->
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <!-- owl.carousel css -->
    <link href="{{ asset('frontend/css/owl.css') }}" rel="stylesheet">
    <!-- fancybox css -->
    <link href="{{ asset('frontend/css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/hover.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <!-- revolution slider css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/revolution/settings.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/revolution/layers.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/revolution/navigation.css') }}">

    <!--Favicon-->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <script src="{{asset('backend/custom-js/axios.min.js')}}"></script>
    <link href="{{asset('backend/custom-css/toastify.min.css')}}" rel="stylesheet" />
</head>

<body>
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

       @include('frontend.layout.header')

        <!--Page Info-->
      <!--  @include('frontend.layout.breadcrumb') -->
        <!--Page Info end-->

       @yield('content')

       @include('frontend.layout.footer')


    </div>
    <!--End pagewrapper-->

    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target=".site-header"><span class="icon fa fa-long-arrow-up"></span></div>

    <!-- jquery Liabrary -->
    <script src="{{ asset('frontend/js/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap v3.3.6 js -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- fancybox js -->
    <script src="{{ asset('frontend/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.fancybox-media.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('frontend/js/owl.js') }}"></script>
    <!-- counter js -->
    <script src="{{ asset('frontend/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countTo.js') }}"></script>
    <!-- mixitup js -->
    <script src="{{ asset('frontend/js/mixitup.js') }}"></script>
    <!-- validate js -->
    <script src="{{ asset('frontend/js/validate.js') }}"></script>

    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/jquery.themepunch.revolution.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.migration.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/revolution/extensions/revolution.extension.video.min.js') }}"></script>

    <!-- script JS  -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    
    <!-- custom-js --> 
    <script src="{{asset('backend/custom-js/toastify-js.js')}}"></script>
    <script src="{{asset('backend/custom-js/config.js')}}"></script>

</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", async function () {
    try {
        const res = await axios.get('/setting-list');

        if (res.status === 200 && res.data.status === "success") {
            const firstData = res.data.data;

            if (firstData) {
                document.getElementById('address').innerText = firstData.address || 'N/A';
                document.getElementById('phone').innerText = firstData.phone1 || 'N/A';
                document.getElementById('email').innerText = firstData.email || 'N/A';

                const logoUrl = `{{ asset('upload/site-setting/') }}/${firstData.logo}`;
                const logoElement = document.getElementById('logo');
                const logoElement2 = document.getElementById('logo2');

                if (logoElement) logoElement.src = logoUrl;
                if (logoElement2) logoElement2.src = logoUrl;

                document.getElementById('descriptionContactPage').innerHTML = firstData.description || 'No description available';
                document.getElementById('addressContactPage').innerText = firstData.address || 'N/A';
                document.getElementById('cityContactPage').innerText = firstData.city || 'N/A';
                document.getElementById('countryContactPage').innerText = firstData.country || 'N/A';
                document.getElementById('phone1ContactPage').innerText = firstData.phone1 || 'N/A';
                document.getElementById('phone2ContactPage').innerText = firstData.phone2 || 'N/A';
                document.getElementById('emailContactPage').innerText = firstData.email || 'N/A';
            } else {
                errorToast("No data found");
            }
        } else {
            errorToast("Error fetching data: " + (res.data.message || "Request failed"));
        }
    } catch (error) {
        if (error.response) {
            if (error.response.status === 404) {
                errorToast("No data found: " + (error.response.data.message || "Data not available"));
            } else if (error.response.status === 500) {
                errorToast("Server error: " + (error.response.data.error || "An error occurred on the server"));
            } else {
                errorToast("Request failed: " + (error.response.data.message || "Unexpected error"));
            }
        } else {
            console.log("Request failed: " + error.message);
            //errorToast("Request failed: " + error.message);
        }
    }

    // Activate current navigation link
    const currentUrl = window.location.href;
    const navigationLinks = document.querySelectorAll('.navigation a');
    navigationLinks.forEach(function (link) {
        if (link.href === currentUrl) {
            link.parentNode.classList.add('current');
        }
    });
});

</script>




