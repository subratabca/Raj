<div id="create-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Create New About Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="save-form">
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="title" placeholder="Enter Title">
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="description" placeholder="Enter Description"></textarea>
              </div>
            </div>

            <div class="col-lg-4">
              <label class="form-control-label">Upload Image:</label><br>
              <label class="custom-file">
                <input type="file" class="custom-file-input" id="image" onChange="mainImageUrl(this)">
                <span class="custom-file-control"></span>
              </label>
              <div></div>
              <img src="" id="mainImage" class="mt-1">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="Save()" id="save-btn" class="btn btn-info pd-x-20">Save</button>
        <button class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('abouts') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>




<script>
function mainImageUrl(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#mainImage').attr('src', e.target.result).width(200).height(150);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function resetCreateForm() {
  // Clear form fields and reset image preview
  document.getElementById('save-form').reset();
  $('#mainImage').attr('src', '');

  // Reset Summernote content
  $('.summernote').summernote('code', '');
}

// Call resetCreateForm when the modal is shown
$('#create-modal').on('show.bs.modal', function (e) {
  resetCreateForm();
});

async function Save() {
  let title = document.getElementById('title').value;
  let description = $('.summernote').summernote('code'); 
  let image = document.getElementById('image').files[0];

  if (title.length === 0) {
    errorToast("Title Required !");
  } else if (description.length === 0) {
    errorToast("Description Required !");
  } else if (!image) {
    errorToast("Image Required !");
  } else {
    document.getElementById('modal-close').click();
    let formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('image', image);

    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };

    let res = await axios.post("/admin/create-about", formData, config);
    if (res.status === 201) {
      successToast('Request completed');
      resetCreateForm(); 
      await getList();
    } else {
      errorToast("Request fail !");
    }
  }
}

</script>

