<div id="create-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Create Site Setting Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="save-form">
          <div class="row mg-b-25">

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Company Name: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="name" placeholder="Enter company name">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="email" placeholder="Enter email">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Phone1: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="phone1" placeholder="Enter phone1">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Phone2: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="phone2" placeholder="Enter phone2">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Address: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="address" placeholder="Enter address">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">City: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="city" placeholder="Enter city">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Country: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="country" placeholder="Enter country">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Zip Code: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="zip_code" placeholder="Enter zip code">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Facebook Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="facebook" placeholder="Enter facebook link">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Linkedin Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="linkedin" placeholder="Enter linkedin link">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Youtube Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="youtube" placeholder="Enter youtube link">
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="description" placeholder="Enter description"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Refund Policy: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote1" id="refund" placeholder="Enter refund policy"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Terms & Condition: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote2" id="terms" placeholder="Enter terms & condition"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Privacy Policy: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote3" id="privacy" placeholder="Enter privacy policy"></textarea>
              </div>
            </div>

            <div class="col-lg-4">
              <label class="form-control-label">Upload Logo:</label><br>
              <label class="custom-file">
                <input type="file" class="custom-file-input" id="logo" onChange="mainImageUrl(this)">
                <span class="custom-file-control"></span>
              </label>
              <div></div>
              <img src="{{asset('/upload/no_image.jpg')}}" id="mainImage" class="mt-1" style="width: 120px; height: 100px;">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="Save()" id="save-btn" class="btn btn-info pd-x-20">Save</button>
        <button class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('site.settings') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>




<script>
function mainImageUrl(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#mainImage').attr('src', e.target.result).width(120).height(100);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function resetCreateForm() {
  document.getElementById('save-form').reset();
  $('#mainImage').attr('src', '');

  $('.summernote').summernote('code', '');
  $('.summernote1').summernote('code', '');
  $('.summernote2').summernote('code', '');
  $('.summernote3').summernote('code', '');
}

$('#create-modal').on('show.bs.modal', function (e) {
  resetCreateForm();
});

async function Save() {
  let name = document.getElementById('name').value;
  let email = document.getElementById('email').value;
  let phone1 = document.getElementById('phone1').value;
  let phone2 = document.getElementById('phone2').value;

  let address = document.getElementById('address').value;
  let city = document.getElementById('city').value;
  let country = document.getElementById('country').value;
  let zip_code = document.getElementById('zip_code').value;

  let facebook = document.getElementById('facebook').value;
  let linkedin = document.getElementById('linkedin').value;
  let youtube = document.getElementById('youtube').value;

  let description = $('.summernote').summernote('code'); 
  let refund = $('.summernote1').summernote('code'); 
  let terms = $('.summernote2').summernote('code');
  let privacy = $('.summernote3').summernote('code'); 
  let logo = document.getElementById('logo').files[0];

  if (name.length === 0) {
    errorToast("Name Required !");
  } 
  else if (email.length === 0) {
    errorToast("Email Required !");
  } 
  else if (phone1.length === 0) {
    errorToast("Phone1 Required !");
  } 
  else if (phone2.length === 0) {
    errorToast("Phone2 Required !");
  }

  else if (address.length === 0) {
    errorToast("Address Required !");
  }
  else if (city.length === 0) {
    errorToast("City Required !");
  }
  else if (country.length === 0) {
    errorToast("Country Required !");
  }
  else if (zip_code.length === 0) {
    errorToast("Zip Code Required !");
  }

  else if (facebook.length === 0) {
    errorToast("Facebook Link Required !");
  } 
  else if (linkedin.length === 0) {
    errorToast("Linkedin Link Required !");
  } 
  else if (youtube.length === 0) {
    errorToast("Youtube Link Required !");
  }

  else if (description.length === 0) {
    errorToast("Description Required !");
  } 
  else if (refund.length === 0) {
    errorToast("Refund Policy Required !");
  } 
  else if (terms.length === 0) {
    errorToast("Terms & Condition Required !");
  } 
  else if (privacy.length === 0) {
    errorToast("Privacy Policy Required !");
  } 
  else if (!logo) {
    errorToast("Logo Required !");
  } 
  else {
    document.getElementById('modal-close').click();
    let formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone1', phone1);
    formData.append('phone2', phone2);

    formData.append('address', address);
    formData.append('city', city);
    formData.append('country', country);
    formData.append('zip_code', zip_code);

    formData.append('facebook', facebook);
    formData.append('linkedin', linkedin);
    formData.append('youtube', youtube);

    formData.append('description', description);
    formData.append('refund', refund);
    formData.append('terms', terms);
    formData.append('privacy', privacy);

    formData.append('logo', logo);

    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };

    let res = await axios.post("/admin/create-site-setting", formData, config);
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

