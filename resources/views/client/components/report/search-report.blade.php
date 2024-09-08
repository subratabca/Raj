
<div id="result" style="display:none;">
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
          <h3 class="mg-b-0 tx-white tx-lato tx-bold" id='cancel-orders'>0</h3>
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
</div>

<div class="row row-sm mg-t-20" id='search'>
  <!-- Search by Date -->
  <div class="col-xl-6">
    <div class="card pd-20 pd-sm-40">
      <h6 class="card-body-title">Search by Date</h6>
      <span><hr style="border: 1px solid #000000 !important;"></span>
      <div class="form-layout">
        <div class="row mg-b-25">
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Date: <span class="tx-danger">*</span></label>
              <input class="form-control" type="date" id="single-date" name="single-date" placeholder="Select a date">
              <span id="single-date-error" class="text-danger"></span>
            </div>
          </div>
        </div>
        <div class="form-layout-footer">
          <button class="btn btn-info mg-r-5" onclick="Save('single')">Search</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Search by Date Range -->
  <div class="col-xl-6">
    <div class="card pd-20 pd-sm-40">
      <h6 class="card-body-title">Search by Date Range</h6>
      <span><hr style="border: 1px solid #000000 !important;"></span>
      <div class="form-layout">
        <div class="row mg-b-25">
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Start Date: <span class="tx-danger">*</span></label>
              <input class="form-control" type="date" id="start-date" name="start-date" placeholder="Select start date">
              <span id="start-date-error" class="text-danger"></span>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">End Date: <span class="tx-danger">*</span></label>
              <input class="form-control" type="date" id="end-date" name="end-date" placeholder="Select end date">
              <span id="end-date-error" class="text-danger"></span>
            </div>
          </div>
        </div>
        <div class="form-layout-footer">
          <button class="btn btn-info mg-r-5" onclick="Save('range')">Search</button>
        </div>
      </div>
    </div>
  </div>
</div>  

<script>
  async function Save(criteria) {
    let formData = new FormData();

    document.getElementById('single-date-error').innerText = '';
    document.getElementById('start-date-error').innerText = '';
    document.getElementById('end-date-error').innerText = '';

    if (criteria === 'single') {
      let singleDate = document.getElementById('single-date').value;

      if (!singleDate) {
        document.getElementById('single-date-error').innerText = 'Please select a date!';
        return;
      }

      formData.append('date', singleDate);

    } else if (criteria === 'range') {
      let startDate = document.getElementById('start-date').value;
      let endDate = document.getElementById('end-date').value;

      if (!startDate) {
        document.getElementById('start-date-error').innerText = 'Please select a start date!';
        return;
      }

      if (!endDate) {
        document.getElementById('end-date-error').innerText = 'Please select an end date!';
        return;
      }

      formData.append('start_date', startDate);
      formData.append('end_date', endDate);
    }

    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };

    try {
      let res = await axios.post("/client/order/by/search", formData, config);

      if (res.status === 200) {
        document.getElementById('result').style.display = 'block';
        document.getElementById('search').style.display = 'none';

        document.getElementById('total-orders').innerText = res.data.total_orders;
        document.getElementById('completed-orders').innerText = res.data.total_completed_orders;
        document.getElementById('pending-orders').innerText = res.data.total_pending_orders;
        document.getElementById('approve-request-orders').innerText = res.data.total_approved_food_request_orders;
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
      } 
    } catch (error) {
      let errorMessage = 'An unexpected error occurred.';

      if (error.response) {
          const status = error.response.status;
          errorMessage = error.response.data.message || errorMessage;

          if (status === 400) {
              document.getElementById('single-date-error').innerText = error.response.data.message || 'Please provide a valid date';
              document.getElementById('start-date-error').innerText = error.response.data.message || 'Please select a start date!';
              document.getElementById('end-date-error').innerText = error.response.data.message || 'Please select an end date!';
          } else if (status === 404) {
              errorMessage = error.response.data.message || 'No orders found for the provided criteria.';
          } else if (status === 500) {
              errorMessage = error.response.data.message || 'An unexpected error occurred.';
          }
          errorToast(errorMessage);
      } else {
          errorToast(errorMessage);
      }
    }

  }
</script>

