<div class="sl-sideright">
    <ul class="nav nav-tabs nav-fill sidebar-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#notifications">
                Notifications (<span id="notificationCount2"></span>)
            </a><br>
            <a href="javascript:void(0);" id="markAllAsRead" class="tx-12" style="color:green;">
                <strong>Mark All as Read</strong>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane pos-absolute a-0 mg-t-60 active" id="messages" role="tabpanel">
            <div class="media-list">
                
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('markAllAsRead').addEventListener('click', async function() {
    try {
        const response = await axios.post('/client/markAsRead');
        if (response.status === 200) {
            document.getElementById('notificationCount').innerText = '0';
            document.getElementById('notificationCount2').innerText = '0';
            window.location.reload(); 
        } else {
            errorToast(response.data.message || 'An unexpected error occurred.');
        }
    } catch (error) {
        if (error.response) {
            const status = error.response.status;
            const message = error.response.data.message || 'An unexpected error occurred';

            if (status === 400) {
                errorToast(error.response.data.message || 'Bad Request');
            } else if (status === 404) {
                errorToast(error.response.data.error || 'Not Found');
            } else if (status === 500) {
                errorToast(error.response.data.error || 'Server Error');
            } else {
                errorToast(message);
            }
        } else if (error.request) {
            errorToast('No response received from the server.');
        } else {
            errorToast('Error: ' + error.message);
        }
    }
});

</script>


