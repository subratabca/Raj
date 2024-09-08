<div class="sidebar-page-container">
    <!-- Tabs Box -->
    <div class="auto-container">
        <div class="row clearfix">

            <!-- Sidebar -->
            @include('frontend.components.dashboard.left-sidebar')
            <!-- End Sidebar -->

            <!-- Content Side -->
            <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card pd-20 pd-sm-40">
                            <h4><strong>Food Details</strong></h4>
                            <table class="table table-bordered">
                              <tbody>
                                <tr>
                                  <th class="wd-30p"><strong>Food Image :</strong></th>
                                  <td><img style="width: 150px; height: 100px;" id="food-image" src="{{ asset('/upload/no_image.jpg') }}" alt="Food Image"/></td>
                                </tr>
                                <tr>
                                  <th><strong>Food Name :</strong></th>
                                  <td id="food-name"></td>
                                </tr>
                                <tr>
                                  <th><strong>Food Gradients :</strong></th>
                                  <td id="food-gradients"></td>
                                </tr>
                                <tr>
                                  <th><strong>Food Description :</strong></th>
                                  <td id="food-description"></td>
                                </tr>
                                <tr>
                                  <th><strong>Food Provider :</strong></th>
                                  <td id="food-provider"></td>
                                </tr>
                                <tr>
                                  <th><strong>Food Requested By :</strong></th>
                                  <td id="food-requester"></td>
                                </tr>
                                <tr>
                                  <th><strong>Delivery Status :</strong></th>
                                  <td id="food-delivery-status"></td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card pd-20 pd-sm-40">
                            <h4><strong>Order Details</strong></h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">Order Date</th>
                                        <th class="wd-10p">Order Time</th>
                                        <th class="wd-10p">Approve Order Date</th>
                                        <th class="wd-10p">Approve Order Time</th>
                                        <th class="wd-10p">Food Delivery Date</th>
                                        <th class="wd-10p">Food Delivery Time</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList1">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Content Side -->

        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        OrderDetailsInfo();
    });

    async function OrderDetailsInfo() {
        let url = window.location.pathname;
        let segments = url.split('/');
        let id = segments[segments.length - 1];

        try {
            let res = await axios.get("/user/order-details-info/" + id);
            let data = res.data.data;

            document.getElementById('food-image').src = '/upload/food/large/' + data.food.image;
            document.getElementById('food-name').innerText = data.food.name;
            document.getElementById('food-gradients').innerText = data.food.gradients;
            document.getElementById('food-description').innerHTML = data.food.description;
            document.getElementById('food-provider').innerText = data.food.user.firstName;
            document.getElementById('food-requester').innerText = data.user.firstName;
            document.getElementById('food-delivery-status').innerText = data.status.charAt(0).toUpperCase() + data.status.slice(1); // Capitalize first letter of status

            let tableList1 = $("#tableList1");
            tableList1.empty();

            let row1 = `<tr>
                      <td>${data.order_date}</td>
                      <td>${data.order_time}</td>
                      <td>${data.approve_date}</td>
                      <td>${data.approve_time}</td>
                      <td>${data.delivery_date}</td>
                      <td>${data.delivery_time}</td>
                     </tr>`;
            tableList1.append(row1);

        } catch (error) {
            console.error('Error fetching order details:', error);
            // Optionally display an error message to the user
            alert('Failed to fetch order details. Please try again later.');
        }
    }
</script>

