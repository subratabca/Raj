<div class="row row-sm">
  <div class="col-sm-6 col-xl-3">
    <div class="card pd-20 bg-primary">
      <div class="d-flex justify-content-between align-items-center mg-b-10">
        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Today's Total Order</h6>
        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='total-orders'>0</h3>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
    <div class="card pd-20 bg-info">
      <div class="d-flex justify-content-between align-items-center mg-b-10">
        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Completed Order</h6>
        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='completed-orders'>0</h3>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
    <div class="card pd-20 bg-purple">
      <div class="d-flex justify-content-between align-items-center mg-b-10">
        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Order Approve Request</h6>
        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='approve-request-orders'>0</h3>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
    <div class="card pd-20 bg-sl-primary">
      <div class="d-flex justify-content-between align-items-center mg-b-10">
        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Pending Order</h6>
        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='pending-orders'>0</h3>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-20">
    <div class="card pd-20 bg-danger">
      <div class="d-flex justify-content-between align-items-center mg-b-10">
        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Pending Order</h6>
        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
      </div><!-- card-header -->
      <div class="d-flex align-items-center justify-content-between">
        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='cancel-orders'></h3>
      </div>
    </div>
  </div>

</div>

<div class="card pd-20 pd-sm-40 mg-t-15">
    <h6 class="card-body-title">Order List Information</h6><br>
    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-10p">Image</th>
                    <th class="wd-10p">Food Nmae</th>
                    <th class="wd-10p">Order Date</th>
                    <th class="wd-10p">Order Time</th>
                    <th class="wd-10p">Order By</th>
                    <th class="wd-10p">Status</th>
                    <th class="wd-20p">Action</th>
                </tr>
            </thead>

            <tbody id="tableList">

            </tbody>

        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        getList();
    });

    async function getList() {
        try {
            let res = await axios.get("/client/todays/order/information");

            document.getElementById('total-orders').innerText = res.data.total_orders;
            document.getElementById('completed-orders').innerText = res.data.total_completed_orders;
            document.getElementById('approve-request-orders').innerText = res.data.total_approved_food_request_orders;
            document.getElementById('pending-orders').innerText = res.data.total_pending_orders;
            document.getElementById('cancel-orders').innerText = res.data.total_canceled_orders;

            let tableList = $("#tableList");
            let tableData = $("#datatable1");

            tableData.DataTable().destroy(); 
            tableList.empty(); 

            res.data.data.forEach(function (item, index) {
                let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${item['food']['image'] ? `<img src="/upload/food/small/${item['food']['image']}" width="50" height="50">` : `<img src="/upload/no_image.jpg" width="50" height="50">`}
                            </td>
                            <td>${item['food']['name']}</td>
                            <td>${item['order_date']}</td>
                            <td>${item['order_time']}</td>
                            <td>${item['user']['firstName']}</td>
                            <td>
                                <span class="badge ${item['status'] === 'pending' ? 'bg-danger' : 'bg-success'}">${item['status']}</span>
                            </td>
                            <td>
                                <button data-path="/upload/food/small/${item['food']['image']}" data-id="${item['id']}" class="btn detailsBtn btn-sm btn-outline-primary">Details</button>
                            </td>
                         </tr>`;
                tableList.append(row);
            });

            $('.detailsBtn').on('click', async function () {
                let id = $(this).data('id');
                let filePath = $(this).data('path');
                await FillUpShowForm(id, filePath);
                $("#show-modal").modal('show');
            });
            
            tableData.DataTable({
                responsive: true
            });
        } catch (error) {
            if (error.response) {
                if (error.response.status === 404) {
                    if (error.response.data.message) {
                        errorToast(error.response.data.message);
                    } else {
                        errorToast("Data not found.");
                    }
                }
                else if (error.response.status === 500) {
                    if (error.response.data.error) {
                        errorToast(error.response.data.error);
                    } else {
                        errorToast("An internal server error occurred.");
                    }
                }
                else {
                    errorToast("Request failed!");
                }
            }
            else {
                errorToast("Request failed!");
            }
        }
    }

</script>