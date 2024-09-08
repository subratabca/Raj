<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">
            @include('frontend.components.dashboard.left-sidebar')
            <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="container">
                  <h2>Total Food Request Details</h2><hr>
                  <div class="card-deck">
                    <div class="card">
                      <div class="card-header text-center">Total Request</div>
                      <div class="card-body text-center" id="totalRequest">0</div>
                    </div>

                    <div class="card">
                      <div class="card-header text-center">Pending</div>
                      <div class="card-body text-center" id="pendingOrder">0</div>
                    </div>

                    <div class="card">
                      <div class="card-header text-center">Completed</div>
                      <div class="card-body text-center" id="completedOrder">0</div>
                    </div>

                    <div class="card">
                      <div class="card-header text-center">Canceled</div>
                      <div class="card-body text-center" id="canceledOrder">0</div>
                    </div>  
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

@if(Cookie::get('token') !== null)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        OrderDetailsInfo();
    });

    async function OrderDetailsInfo() {
        try {
            let res = await axios.get("/user/dashboard-order-details");
            let data = res.data.data;

            // Update card values
            document.getElementById('totalRequest').innerText = data.totalRequest;
            document.getElementById('pendingOrder').innerText = data.pendingOrder;
            document.getElementById('completedOrder').innerText = data.completedOrder;
            document.getElementById('canceledOrder').innerText = data.canceledOrder;

        } catch (error) {
            console.error('Error fetching order details:', error);

            // Display error message using errorToast
            if (error.response) {
                // The request was made and the server responded with a status code
                const status = error.response.status;
                const message = error.response.data.message || 'An error occurred';

                switch (status) {
                    case 404:
                        errorToast('Order information not found');
                        break;
                    case 500:
                        errorToast('An error occurred while fetching the order details');
                        break;
                    default:
                        errorToast(message);
                }
            } else {
                errorToast('Failed to fetch order details. Please try again later.');
            }
        }
    }
</script>
@endif
