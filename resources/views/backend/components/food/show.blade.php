<div id="show-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Food Details Information</h6>
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
                          <input type="text" class="d-none" id="updateShowID">
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
                            <th><strong>Food Status :</strong></th>
                            <td id="food-status"></td>
                          </tr>
                          <tr>
                            <th><strong>Food Provider :</strong></th>
                            <td id="food-provider"></td>
                          </tr>
                          <tr>
                            <th><a href="/admin/terms-conditions/food_upload" target="_blank"><strong>Food Upload T&C :</strong></a></th>
                            <td id="food-upload-tnc"></td>
                          </tr>
                        </tbody>
                      </table>
                    </p>
                  </div>

                  <div class="card-footer tx-center bg-gray-300">
                    <button onclick="statusUpdate()" id="food-status-update-btn" class="btn btn-info pd-x-20">Publish</button>
                  </div>
                </div>
            </div>

            <div class="col-lg-6">

            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button  class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('foods') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>


<script>
   async function FillUpShowForm(id,filePath){
      document.getElementById('updateShowID').value = id;
      try {
          let res = await axios.get("/admin/show/" + id);
          let foodImages = res.data.data.food_images;

          let parser = new DOMParser();
          let doc = parser.parseFromString(res.data.data['description'], 'text/html');

          let collectionDate = new Date(res.data.data['collection_date']);
          let formattedDate = collectionDate.toLocaleDateString('en-GB', {
              day: '2-digit',
              month: 'long',
              year: 'numeric'
          });

          let formattedStartTime = formatTime(res.data.data['start_collection_time']);
          let formattedEndTime = formatTime(res.data.data['end_collection_time']);
          
          document.getElementById('food-image').src = filePath;
          document.getElementById('food-name').innerText = res.data.data['name'];
          document.getElementById('food-gradients').innerText = res.data.data['gradients'];
          document.getElementById('food-description').innerText = doc.body.textContent;
          document.getElementById('food-collection-address').innerText = res.data.data['address'];
          document.getElementById('food-collection-date').innerText = `${formattedDate}`;
          document.getElementById('food-collection-time').innerText = `${formattedStartTime} - ${formattedEndTime}`;

          let status = res.data.data['status'];
          let badgeClass = status === 'pending' ? 'bg-danger' : 'bg-success';
          document.getElementById('food-status').innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;

          document.getElementById('food-provider').innerText = res.data.data['user']['firstName'];

          let food_upload_tnc_status = res.data.data['accept_tnc'];
          let tncText = food_upload_tnc_status === 0 ? 'Not Accepted' : 'Accepted';
          let tncClass = food_upload_tnc_status === 0 ? 'bg-danger' : 'bg-success';
          document.getElementById('food-upload-tnc').innerHTML = `<span class="badge ${tncClass}">${tncText}</span>`;


          let button = document.getElementById('food-status-update-btn');
          button.innerText = status === 'pending' ? 'Published' : 'Pending';
          button.disabled = status !== 'pending';

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

      } catch (error) {
          console.error('Error fetching food information:', error);
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

  async function statusUpdate(event) {
    event.preventDefault();

    let id = document.getElementById('updateShowID').value;
    try {
      let res = await axios.post("/admin/update/status/",{id:id});

      if (res.status === 200) {
        successToast(res.data.message || "Food status updated successfully");
        await getList();
        $("#show-modal").modal('hide');
      } else {
        errorToast("Request failed");
      }
    } catch (error) {
      if (error.response) {
        let errorMessage = error.response.data.message || "Status update failed";
        errorToast(errorMessage);
      } else {
        errorToast("An unexpected error occurred: " + error.message);
      }
    }
  }

  document.getElementById('food-status-update-btn').addEventListener('click', statusUpdate);
</script>


