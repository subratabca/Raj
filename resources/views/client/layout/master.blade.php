<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>@yield('title')</title>

    <!-- vendor css -->
    <link href="{{ asset('backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/highlightjs/github.css') }}" rel="stylesheet">

    <!-- summernote css -->
    <link href="{{ asset('backend/lib/medium-editor/medium-editor.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/medium-editor/default.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <!-- Bootstrap Tags Input CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- datatable css -->
    <link href="{{ asset('backend/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">


    <!-- toastify css -->
    <link href="{{asset('backend/custom-css/toastify.min.css')}}" rel="stylesheet" />

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/starlight.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


  </head>

  <body>

     @include('client.layout.left-sidebar')

     @include('client.layout.header')

     @include('client.layout.right-sidebar')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Client</a>
        <span class="breadcrumb-item active">@yield('breadcum')</span>
      </nav>

      <div class="sl-pagebody">

        @yield('content')

      </div>
      @include('client.layout.footer')
    </div>
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="{{ asset('backend/lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('backend/lib/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('backend/lib/highlightjs/highlight.pack.js') }}"></script>

    <!-- summernote js -->
    <script src="{{ asset('backend/lib/medium-editor/medium-editor.js') }}"></script>
    <script src="{{ asset('backend/lib/summernote/summernote-bs4.min.js') }}"></script>

    <!-- datatables js -->  
    <script src="{{ asset('backend/lib/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('backend/lib/select2/js/select2.min.js') }}"></script>

    <!-- custom-js --> 
    <script src="{{asset('backend/custom-js/toastify-js.js')}}"></script>
    <script src="{{asset('backend/custom-js/axios.min.js')}}"></script>
    <script src="{{asset('backend/custom-js/config.js')}}"></script>

    <!-- Bootstrap Tags Input JS -->
    <script src="{{asset('backend/custom-js/tag.js')}}"></script>
    
    <script src="{{ asset('backend/js/starlight.js') }}"></script>

    <!-- Bootstrap Tags Input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script>
    profileInfo();

    async function profileInfo() {
        try {
            const response = await axios.get('/client/profile/info');

            if (response.status === 200) {
                const userData = response.data.data;
                const unreadNotifications = response.data.unreadNotifications;
                const readNotifications = response.data.readNotifications;

                document.getElementById('userName').innerText = userData.firstName || 'No User';
                document.getElementById('client-header-img').src = userData['image'] ? "/upload/client-profile/small/" + userData['image'] : "/upload/no_image.jpg";
                document.getElementById('notificationCount').innerText = unreadNotifications.length;
                document.getElementById('notificationCount2').innerText = unreadNotifications.length;

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
    }

    function displayNotifications(unreadNotifications, readNotifications) {
        const notificationsContainer = document.querySelector('.media-list');
        let notificationsHTML = '';

        if ((unreadNotifications && unreadNotifications.length === 0) && 
            (readNotifications && readNotifications.length === 0)) {
            notificationsContainer.innerHTML = '<p>No notifications</p>';
            return;
        }

        // Display unread notifications
        if (unreadNotifications && unreadNotifications.length > 0) {
            unreadNotifications.forEach(notification => {
                notificationsHTML += `
                    <div class="notification-item">
                        <a href="/client/markAsRead/notification/${notification.id}" class="media-list-link">
                            <div class="media pd-x-20 pd-y-15">
                                <div class="media-body">
                                    <p class="tx-13 mg-b-5 tx-gray-800"><strong>${notification.data.data}</strong></p>
                                    <span class="tx-12">${new Date(notification.created_at).toLocaleString()}</span>
                                </div>
                            </div>
                        </a>
                        <button class="delete-notification-btn" onclick="deleteNotification(${notification.id})">Delete</button>
                    </div>`;
            });
        }

        // Display read notifications
        if (readNotifications && readNotifications.length > 0) {
            readNotifications.forEach(notification => {
                notificationsHTML += `
                    <div class="notification-item">
                        <a href="/client/markAsRead/notification/${notification.id}" class="media-list-link">
                            <div class="media pd-x-20 pd-y-15">
                                <div class="media-body">
                                    <p class="tx-13 mg-b-5 tx-gray-600"><strong>${notification.data.data}</strong></p>
                                    <span class="tx-12">${new Date(notification.created_at).toLocaleString()}</span>
                                </div>
                            </div>
                        </a>
                        <button class="delete-notification-btn" onclick="deleteNotification(${notification.id})">Delete</button>
                    </div>`;
            });
        }

        notificationsContainer.innerHTML = notificationsHTML;
    }

    async function deleteNotification(notificationId) {
        try {
            const response = await axios.get(`/client/delete/notification/${notificationId}`);
            
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


</script>

    <script>
      $(function(){
        'use strict';
            //summernote start
            var editor = new MediumEditor('.editable');
            $('.summernote').summernote({
              height: 150,
              tooltip: false,
              toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
              ],
              styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']
            })
           //summernote end

            //summernote start
            var editor = new MediumEditor('.editable');
            $('.summernote1').summernote({
              height: 150,
              tooltip: false
            })
           //summernote end

            //summernote start
            var editor = new MediumEditor('.editable');
            $('.summernote2').summernote({
              height: 150,
              tooltip: false
            })
           //summernote end

            //datatable start
            $('#datatable1').DataTable({  
              responsive: true,
              language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
              }
            });

            // Select2
            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
           //datatable end

      });

    </script>

  </body>
</html>


