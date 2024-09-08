<div id="create-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Create Terms & Conditions Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="save-form">
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Food Upload: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="food-upload" placeholder="Enter food upload terms & conditions"></textarea>
                <span class="error-message text-danger" id="food-upload-error"></span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Request Approve: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote1" id="request-approve" placeholder="Enter request approve terms & conditions"></textarea>
                <span class="error-message text-danger" id="request-approve-error"></span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Food Deliver: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote2" id="food-deliver" placeholder="Enter food deliver terms & conditions"></textarea>
                <span class="error-message text-danger" id="food-deliver-error"></span>
              </div>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="Save()" id="save-btn" class="btn btn-info pd-x-20">Save</button>
        <button class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('terms.conditions') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>

<script>
  function resetCreateForm() {
    document.getElementById('save-form').reset();
    $('.summernote').summernote('code', '');
    $('.summernote1').summernote('code', '');
    $('.summernote2').summernote('code', '');
  }

  $('#create-modal').on('show.bs.modal', function (e) {
    resetCreateForm();
  });


  function stripHTML(html) {
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
  }

  async function Save() {
    let food_upload = $('.summernote').summernote('code'); 
    let request_approve = $('.summernote1').summernote('code'); 
    let food_deliver = $('.summernote2').summernote('code');

    // Clear previous error messages
    document.getElementById('food-upload-error').innerText = '';
    document.getElementById('request-approve-error').innerText = '';
    document.getElementById('food-deliver-error').innerText = '';

    if (stripHTML(food_upload).length === 0) {
        errorToast("Food Upload Field Required !");
    } 
    else if (stripHTML(request_approve).length === 0) {
        errorToast("Request Approve Field Required !");
    } 
    else if (stripHTML(food_deliver).length === 0) {
        errorToast("Food Deliver Field Required !");
    }  
    else {
      let formData = new FormData();
      formData.append('food_upload', food_upload);
      formData.append('request_approve', request_approve);
      formData.append('food_deliver', food_deliver);

      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      };

      try {
        let res = await axios.post("/admin/create-terms-conditions", formData, config);

        if (res.status === 201) {
          successToast(res.data.message || 'Request success');
          resetCreateForm();
          $('#create-modal').modal('hide'); 
          await getList();
        } else {
          errorToast(res.data.message || "Request failed");
        }
      } catch (error) {
      if (error.response && error.response.status === 422) {
        let errorMessages = error.response.data.errors;
        for (let field in errorMessages) {
          if (errorMessages.hasOwnProperty(field)) {
            if (field === 'food_upload') {
              document.getElementById('food-upload-error').innerText = errorMessages[field][0];
            } else if (field === 'request_approve') {
              document.getElementById('request-approve-error').innerText = errorMessages[field][0];
            } else if (field === 'food_deliver') {
              document.getElementById('food-deliver-error').innerText = errorMessages[field][0];
            }
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
