<div id="show-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Order Details Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body bg-gray-200">
                  <p class="mg-b-0">
                    <table class="table table-hover">
                      <tbody>
                        <input type="text" class="d-none" id="updateID">
                        <tr>
                          <th class="wd-25p"><strong>Food Image :</strong></th>
                          <td>
                            <img style="width: 150px; height: 100px;" id="food-image" src="{{asset('/upload/no_image.jpg')}}"/>
                            <span id="food-images-container"></span>
                          </td>
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
                          <th><strong>Collection Address :</strong></th>
                          <td id="food-collection-address"></td>
                        </tr>
                        <tr>
                          <th><strong>Collection Date :</strong></th>
                          <td id="food-collection-date"></td>
                        </tr>
                        <tr>
                          <th><strong>Collection time :</strong></th>
                          <td id="food-collection-time"></td>
                        </tr>
                        <tr>
                          <th><strong>Food Provider :</strong></th>
                          <td id="food-provider"></td>
                        </tr>
                        <tr>
                          <th><strong>Food Request By :</strong></th>
                          <td id="food-requester"></td>
                        </tr>
                        <tr>
                          <th><strong>Requester email :</strong></th>
                          <td id="food-requester-email"></td>
                        </tr>
                        <tr>
                          <th><strong>Requester Phone :</strong></th>
                          <td id="food-requester-phone"></td>
                        </tr>
                      <tr>
                        <th><a href="/client/terms-conditions/food_upload" target="_blank"><strong>Food Upload T&C :</strong></a></th>
                        <td id="food-upload-tnc"></td>
                      </tr>
                      <tr>
                        <th><a href="/client/terms-conditions/request_approve" target="_blank"><strong>Order Request T&C :</strong></a></th>
                        <td id="food-order-request-tnc"></td>
                      </tr>
                      <tr>
                        <th><a href="/client/terms-conditions/food_deliver" target="_blank"><strong>Food Delivery T&C :</strong></a></th>
                        <td id="food-delivery-tnc"></td>
                      </tr>
                        <tr>
                          <th><strong>Order Status :</strong></th>
                          <td id="food-delivery-status"></td>
                        </tr>
                        <tbody id="accept-tnc-row">
                        </tbody>
                  
                      </tbody>
                    </table>
                  </p>
                </div>

                <div class="card-footer tx-center bg-gray-300">
                  <button id="approve-food-request-btn" class="btn btn-info pd-x-20" style="display:none;">Approve Food Request</button>
                  <button id="deliver-food-request-btn" class="btn btn-info pd-x-20" style="display:none;">Deliver Food Request</button>
                  <button id="cancel-food-request-btn" class="btn btn-danger pd-x-20" style="display:none;">Cancel Food Request</button>
                </div>
              </div>
            </div>
          </div>
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <div class="card">
                  <h5>Order Details</h5>
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th class="wd-15p">Order Date</th>
                              <th class="wd-15p">Order Time</th>
                              <th class="wd-15p">Approve Date</th>
                              <th class="wd-15p">Approve Time</th>
                              <th class="wd-15p">Delivery Date</th>
                              <th class="wd-15p">Delivery Time</th>
                          </tr>
                      </thead>
                      <tbody id="tableList1">
                          
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('client.orders') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>

<script>
  async function FillUpShowForm(id, filePath) {
    document.getElementById('updateID').value = id;
    try {
      let res = await axios.get(`/client/order-details/${id}`);
      let foodImages = res.data.data.food.food_images;

      let parser = new DOMParser();
      let doc = parser.parseFromString(res.data.data['food']['description'], 'text/html');

      let collectionDate = new Date(res.data.data['food']['collection_date']);
      let formattedDate = collectionDate.toLocaleDateString('en-GB', {
          day: '2-digit',
          month: 'long',
          year: 'numeric'
      });

      let formattedStartTime = formatTime(res.data.data['food']['start_collection_time']);
      let formattedEndTime = formatTime(res.data.data['food']['end_collection_time']);

      document.getElementById('food-image').src = filePath;
      document.getElementById('food-name').innerText = res.data.data['food']['name'];
      document.getElementById('food-gradients').innerText = res.data.data['food']['gradients'];
      document.getElementById('food-description').innerText = doc.body.textContent;
      document.getElementById('food-collection-address').innerText = res.data.data['food']['address'];
      document.getElementById('food-collection-date').innerText = `${formattedDate}`;
      document.getElementById('food-collection-time').innerText = `${formattedStartTime} - ${formattedEndTime}`;
      document.getElementById('food-provider').innerText = res.data.data['food']['user']['firstName'];
      document.getElementById('food-requester').innerText = res.data.data['user']['firstName'];
      document.getElementById('food-requester-email').innerText = res.data.data['user']['email'];

      let mobileNumber = res.data.data['user']['mobile'];
      let phoneBadge = mobileNumber
        ? `<span class="badge badge-info">${mobileNumber}</span>`
        : `<span class="badge badge-info">Contact Number Not Found</span>`;

      document.getElementById('food-requester-phone').innerHTML = phoneBadge;

      let status = res.data.data['status'];
      let badgeClass = status === 'pending' ? 'badge-danger' : 'badge-success';
      document.getElementById('food-delivery-status').innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;

      document.getElementById('approve-food-request-btn').style.display = status === 'pending' ? 'inline-block' : 'none';
      document.getElementById('deliver-food-request-btn').style.display = status === 'approved food request' ? 'inline-block' : 'none';
      document.getElementById('cancel-food-request-btn').style.display = (status === 'pending' || status === 'approved food request') ? 'inline-block' : 'none';

      // Append all food images
      let foodImagesContainer = document.getElementById('food-images-container');
      foodImagesContainer.innerHTML = ''; // Clear previous images

      foodImages.forEach(image => {
          let imgElement = document.createElement('img');
          imgElement.src = `/upload/food/multiple/${image.image}`; 
          imgElement.style.width = '150px';
          imgElement.style.height = '100px';
          imgElement.style.marginRight = '10px'; // Add some space between images
          foodImagesContainer.appendChild(imgElement);
      });

      let food_upload_tnc_status = res.data.data.food['accept_tnc'];
      let tncText = food_upload_tnc_status === 0 ? 'Not Accepted' : 'Accepted';
      let tncClass = food_upload_tnc_status === 0 ? 'bg-danger' : 'bg-success';
      document.getElementById('food-upload-tnc').innerHTML = `<span class="badge ${tncClass}">${tncText}</span>`;

      let accept_order_request_tnc_status = res.data.data['accept_order_request_tnc'];
      let tncOrderReqText = accept_order_request_tnc_status === 0 ? 'Not Accepted' : 'Accepted';
      let tncOrderReqClass = accept_order_request_tnc_status === 0 ? 'bg-danger' : 'bg-success';
      document.getElementById('food-order-request-tnc').innerHTML = `<span class="badge ${tncOrderReqClass}">${tncOrderReqText}</span>`;

      let accept_food_deliver_tnc_status = res.data.data['accept_food_deliver_tnc'];
      let tncFoodDelText = accept_order_request_tnc_status === 0 ? 'Not Accepted' : 'Accepted';
      let tncFoodDelClass = accept_order_request_tnc_status === 0 ? 'bg-danger' : 'bg-success';
      document.getElementById('food-delivery-tnc').innerHTML = `<span class="badge ${tncFoodDelClass}">${tncFoodDelText}</span>`;

      // Clear previous Accept T&C row if any
      document.getElementById('accept-tnc-row').innerHTML = '';

      // Conditionally render the Accept T&C row
      let acceptTncRow = document.createElement('tr');
      if (status === 'pending') {
        acceptTncRow.innerHTML = `
          <th><strong>Accept T&C For Request Approve :</strong></th>
          <td>
            <div class="col-lg-12">
              <div class="form-group">
                <input type="checkbox" id="accept_tnc" onchange="handleCheckboxChange()">
                <label for="accept_tnc"><a href="/client/terms-conditions/request_approve" target="_blank">Accept T&C For Request Approve</a></label>
                <span class="tx-danger">*</span>
                <span class="error-message text-danger" id="accept_tnc-error"></span>
              </div>
            </div>
          </td>
        `;
      } else if (status === 'approved food request') {
        acceptTncRow.innerHTML = `
          <th><strong>Accept T&C For Food Deliver :</strong></th>
          <td>
            <div class="col-lg-12">
              <div class="form-group">
                <input type="checkbox" id="accept_tnc" onchange="handleCheckboxChange()">
                <label for="accept_tnc"><a href="/client/terms-conditions/food_deliver" target="_blank">Accept T&C For Food Deliver</a></label>
                <span class="tx-danger">*</span>
                <span class="error-message text-danger" id="accept_tnc-error"></span>
              </div>
            </div>
          </td>
        `;
      }

      document.getElementById('accept-tnc-row').appendChild(acceptTncRow);

      let tableList1 = $("#tableList1");
      tableList1.empty();

      let orderDate = res.data.data.order_date === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.order_date}</span>`;

      let orderTime = res.data.data.order_time === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.order_time}</span>`;

      let approveDate = res.data.data.approve_date === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.approve_date}</span>`;

      let approveTime = res.data.data.approve_time === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.approve_time}</span>`;

      let deliveryDate = res.data.data.delivery_date === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.delivery_date}</span>`;

      let deliveryTime = res.data.data.delivery_time === null ? 
          '<span class="badge bg-danger">Pending</span>' : 
          `<span class="badge bg-info">${res.data.data.delivery_time}</span>`;

      let row1 = `<tr>
          <td>${orderDate}</td>
          <td>${orderTime}</td>
          <td>${approveDate}</td>
          <td>${approveTime}</td>
          <td>${deliveryDate}</td>
          <td>${deliveryTime}</td>
      </tr>`;

      tableList1.append(row1);

    } catch (err) {
      console.error('Error fetching order details:', err);
    }
  }

  function formatTime(timeString) {
      let date = new Date('1970-01-01T' + timeString + 'Z');
      let hours = date.getUTCHours();
      let minutes = date.getUTCMinutes();
      let seconds = date.getUTCSeconds();

      let amPm = hours >= 12 ? 'PM' : 'AM';

      hours = hours % 12;
      hours = hours ? hours : 12;

      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      return `${hours}:${minutes}:${seconds} ${amPm}`;
  }

  document.getElementById('approve-food-request-btn').onclick = approveFoodRequest;
  document.getElementById('deliver-food-request-btn').onclick = deliverFoodRequest;
  document.getElementById('cancel-food-request-btn').onclick = cancelFoodRequest;


  // Function to handle checkbox change
  function handleCheckboxChange(event) {
    const checkbox = event.target;
    checkbox.checked = !checkbox.checked; // Toggle the checkbox state
  }
  
  
  async function approveFoodRequest(event) {
    event.preventDefault();
    let accept_tnc = document.getElementById('accept_tnc').checked ? 1 : 0;
    let id = document.getElementById('updateID').value;

    if (!accept_tnc) {
      errorToast("You must accept the terms and conditions!");
      return;
    }

    try {
      let res = await axios.post("/client/approve/food/request/", { id: id, accept_tnc: accept_tnc });
      if (res.status === 200) {
        successToast(res.data.message || "Food request approved successfully.");
        await getList();
        $("#show-modal").modal('hide');
      } else {
        errorToast("Request failed");
      }
    } catch (error) {
      handleRequestError(error);
    }
  }

  async function deliverFoodRequest(event) {
    event.preventDefault();
    let accept_tnc = document.getElementById('accept_tnc').checked ? 1 : 0;
    let id = document.getElementById('updateID').value;

    if (!accept_tnc) {
      errorToast("You must accept the terms and conditions!");
      return;
    }
    
    try {
      let res = await axios.post("/client/delivered/food/request/", { id: id, accept_tnc: accept_tnc });
      if (res.status === 200) {
        successToast(res.data.message || "Food delivered successfully");
        await getList();
        $("#show-modal").modal('hide');
      } else {
        errorToast("Request failed");
      }
    } catch (error) {
      handleRequestError(error);
    }
  }

  async function cancelFoodRequest(event) {
    event.preventDefault();
    let id = document.getElementById('updateID').value;
    try {
      let res = await axios.post("/client/cancel/food/request/", { id: id });
      if (res.status === 200) {
        successToast(res.data.message || "Food request canceled successfully");
        await getList();
        $("#show-modal").modal('hide');
      } else {
        errorToast("Request failed");
      }
    } catch (error) {
      handleRequestError(error);
    }
  }

  function handleRequestError(error) {
    if (error.response) {
      errorToast(error.response.data.message || "An error occurred while processing the request.");
    } else {
      errorToast("Something went wrong. Please try again.");
    }
  }
</script>
