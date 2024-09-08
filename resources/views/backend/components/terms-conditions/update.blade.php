<div id="update-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update Terms & Conditions Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <input type="text" class="d-none" id="updateID">
              <div class="form-group">
                <label class="form-control-label">Food Upload: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="update-food-upload" placeholder="Enter food upload terms & conditions"></textarea>
                <span class="error-message text-danger" id="update_food_upload-error"></span> <!-- Corrected ID -->
              </div>

              <div class="form-group">
                <label class="form-control-label">Request Approve: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote1" id="update-request-approve" placeholder="Enter request approve terms & conditions"></textarea>
                <span class="error-message text-danger" id="update_request_approve-error"></span> <!-- Corrected ID -->
              </div>

              <div class="form-group">
                <label class="form-control-label">Food Deliver: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote2" id="update-food-deliver" placeholder="Enter food deliver terms & conditions"></textarea>
                <span class="error-message text-danger" id="update_food_deliver-error"></span> <!-- Corrected ID -->
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button onclick="updateTermsConditions()" id="update-btn" class="btn btn-info pd-x-20">Update</button>
          <button  class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
          <a href="{{ route('terms.conditions') }}" class="btn btn-success">Back</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function FillUpUpdateForm(id) {
      document.getElementById('updateID').value = id;

      try {
        let res = await axios.post("/admin/terms-conditions-by-id/", { id: id });

        if (res.status === 200 && res.data.status === 'success') {
          $('#update-food-upload').summernote('code', res.data.data['food_upload']);
          $('#update-request-approve').summernote('code', res.data.data['request_approve']);
          $('#update-food-deliver').summernote('code', res.data.data['food_deliver']);
        } else {
          errorToast("Unexpected response. Terms & Conditions data might not be available.");
        }
      } catch (error) {
        if (error.response) {
          if (error.response.status === 404) {
            const errorMessage = error.response.data.message || "Terms & Conditions not found.";
            errorToast(errorMessage);
          } else if (error.response.status === 500) {
            const errorMessage = error.response.data.error || "Internal Server Error. Please try again later.";
            errorToast(errorMessage);
          } else {
            errorToast("An unexpected error occurred.");
          }
        } else {
          console.error('Error fetching Terms & Conditions information:', error);
          errorToast("Network error or server is unreachable.");
        }
      }
    }



    async function updateTermsConditions() {
      let food_upload = document.getElementById('update-food-upload').value;
      let request_approve = document.getElementById('update-request-approve').value;
      let food_deliver = document.getElementById('update-food-deliver').value;
      let updateID = document.getElementById('updateID').value;

// Clear previous error messages
      document.getElementById('update_food_upload-error').innerText = '';
      document.getElementById('update_request_approve-error').innerText = '';
      document.getElementById('update_food_deliver-error').innerText = '';

      if (food_upload.length === 0) {
        errorToast("Food Upload Field Required !");
      } 
      else if (request_approve.length === 0) {
        errorToast("Request Approve Field Required !");
      } 
      else if (food_deliver.length === 0) {
        errorToast("Food Deliver Field Required !");
      }
      else {
        let formData = new FormData();
        formData.append('food_upload', food_upload);
        formData.append('request_approve', request_approve);
        formData.append('food_deliver', food_deliver);
        formData.append('id', updateID);

        const config = {
          headers: {
            'content-type': 'multipart/form-data'
          }
        }

        try {
          let res = await axios.post("/admin/update-terms-conditions", formData, config);
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

