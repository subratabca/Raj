<div id="update-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update Food Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div class="row mg-b-25">
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Food Name: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="update_name" placeholder="Enter food name">
                <span class="error-message text-danger" id="update_name-error"></span>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="form-group">
                <label class="form-control-label">Gradients: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" data-role="tagsinput" id="update_gradients" placeholder="Enter food gradients">
                <span class="error-message text-danger" id="update_gradients-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Expire Date: <span class="tx-danger">*</span></label>
                <input type="date" class="form-control" id="update_expire_date" placeholder="Enter food expire date">
                <span class="error-message text-danger" id="update_expire_date-error"></span>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="form-group">
                <label class="form-control-label">Collection Address: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="update_address" placeholder="Enter food collection address">
                <span class="error-message text-danger" id="update_address-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Date: <span class="tx-danger">*</span></label>
                <input type="date" class="form-control" id="update_collection_date" placeholder="Enter food collection date">
                <span class="error-message text-danger" id="update_collection_date-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Time(From): <span class="tx-danger">*</span></label>
                <input type="time" class="form-control" id="update_start_collection_time" placeholder="Enter food collection start time">
                <span class="error-message text-danger" id="update_start_collection_time-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Time(To): <span class="tx-danger">*</span></label>
                <input type="time" class="form-control" id="update_end_collection_time" placeholder="Enter food collection end time">
                <span class="error-message text-danger" id="update_end_collection_time-error"></span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="update_description"></textarea>
                <span class="error-message text-danger" id="update_description-error"></span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Old Food Image:</label><br>
                    <img style="width: 150px; height: 100px;" id="oldImg" src="{{asset('/images/default.jpg')}}"/>
                  </div>
                </div>

                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <label class="form-control-label">Upload New Food Image: <span class="tx-danger">*</span></label><br>
                      <label class="custom-file">
                        <input type="file" id="imgUpdate" class="custom-file-input" onChange="updateImgUrl(this)" >

                        <input type="text" class="d-none" id="updateID">
                        <input type="text" class="d-none" id="filePath">

                        <span class="custom-file-control"></span>
                      </label>
                      <span class="error-message text-danger" id="update_image-error"></span>
                    </div>
                    <div class="col-lg-6">
                      <img src="" id="updateImg" class="mt-1" width="150";height="100">
                    </div>
                  </div>
                </div>

              </div> 
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="updateFood()" id="update-btn" class="btn btn-info pd-x-20">Update</button>
        <button  class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('foods') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function updateImgUrl(input){
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e){
        $('#updateImg').attr('src',e.target.result).width(150).height(100);
      };
      reader.readAsDataURL(input.files[0]);
    }
  } 
</script>


<script>
   async function FillUpUpdateForm(id,filePath){
      document.getElementById('updateID').value = id;
      document.getElementById('filePath').value = filePath;
      document.getElementById('oldImg').src = filePath;
      $('#updateImg').attr('src', '/upload/no_image.jpg')

      try {
          let res = await axios.post("/admin/edit/",{id:id});
          document.getElementById('update_name').value = res.data['name'];

          // Update gradients field
          let updateGradientsField = $('#update_gradients');
          updateGradientsField.tagsinput('removeAll'); 
          let gradients = res.data['gradients'].split(',');

          gradients.forEach(tag => {
              updateGradientsField.tagsinput('add', tag.trim());
          });

          // Check if there are tags and remove the placeholder if tags exist
          let tagInput = updateGradientsField.siblings('.bootstrap-tagsinput').find('input');

          if (gradients.length > 0 && gradients[0].trim() !== "") {
              tagInput.attr('placeholder', '');  // Remove placeholder
          } else {
              tagInput.attr('placeholder', 'Enter food gradients');  // Reset placeholder
          }

          document.getElementById('update_expire_date').value = res.data['expire_date'];
          document.getElementById('update_address').value = res.data['address'];
          document.getElementById('update_collection_date').value = res.data['collection_date'];
          document.getElementById('update_start_collection_time').value = res.data['start_collection_time'];
          document.getElementById('update_end_collection_time').value = res.data['end_collection_time'];
          $('#update_description').summernote('code', res.data['description']);

      } catch (error) {
          console.error('Error fetching food information:', error);
      }
  }


  async function updateFood() {
    let update_name = document.getElementById('update_name').value;
    let update_gradients = document.getElementById('update_gradients').value;
    let update_expire_date = document.getElementById('update_expire_date').value;
    let update_address = document.getElementById('update_address').value;
    let update_collection_date = document.getElementById('update_collection_date').value;
    let update_start_collection_time = document.getElementById('update_start_collection_time').value;
    let update_end_collection_time = document.getElementById('update_end_collection_time').value;
    let update_description = document.getElementById('update_description').value;
    let update_image = document.getElementById('imgUpdate').files[0];
    let updateID = document.getElementById('updateID').value;
    let filePath = document.getElementById('filePath').value;

    document.getElementById('update_name-error').innerText = '';
    document.getElementById('update_gradients-error').innerText = '';
    document.getElementById('update_expire_date-error').innerText = '';
    document.getElementById('update_address-error').innerText = '';
    document.getElementById('update_collection_date-error').innerText = '';
    document.getElementById('update_start_collection_time-error').innerText = '';
    document.getElementById('update_end_collection_time-error').innerText = '';
    document.getElementById('update_description-error').innerText = '';
    document.getElementById('update_image-error').innerText = '';

    if (update_name.length === 0) {
      errorToast("Food name required !");
    } 
    else if (update_gradients.length === 0) {
      errorToast("Food gradients required !");
    } 
    else if (update_expire_date.length === 0) {
      errorToast("Food expire date required !");
    }
    else if (update_address.length === 0) {
      errorToast("Food colletion address required !");
    }
    else if (update_collection_date.length === 0) {
      errorToast("Food colletion date required !");
    }
    else if (update_start_collection_time.length === 0) {
      errorToast("Food colletion start time required !");
    }
    else if (update_end_collection_time.length === 0) {
      errorToast("Food colletion end time required !");
    }
    else if (update_description.length === 0) {
      errorToast("Food description required !");
    }
    else {
      let formData = new FormData();
          formData.append('name', update_name);
          formData.append('gradients', update_gradients);
          formData.append('expire_date', update_expire_date);
          formData.append('address', update_address);
          formData.append('collection_date', update_collection_date);
          formData.append('start_collection_time', update_start_collection_time);
          formData.append('end_collection_time', update_end_collection_time);
          formData.append('description', update_description);
          if (update_image) {
            formData.append('image', update_image);
          }
          formData.append('id',updateID);
          formData.append('file_path',filePath);

      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      try {
          let res = await axios.post("/admin/update",formData,config)
          if (res.status === 200) {
              successToast(res.data.message || 'Update Success');
              document.getElementById('update-form').reset();
              $('#update-modal').modal('hide');
              await getList(); 
          } else {
              errorToast(res.data.message || "Request failed");
          }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          let errorMessages = error.response.data.errors;
          for (let field in errorMessages) {
            if (errorMessages.hasOwnProperty(field)) {
              document.getElementById(`update_${field}-error`).innerText = errorMessages[field][0];
            }
          }
        } else if (error.response && error.response.status === 500) {
          errorToast(error.response.data.error);
        } else {
          errorToast("Request failed!");
        }
      }
    }
  }
</script>

