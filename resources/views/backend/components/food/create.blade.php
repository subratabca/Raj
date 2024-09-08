<div id="create-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Upload New Food</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="save-form">
          <div class="row mg-b-25">
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Food Name: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="name" placeholder="Enter food name">
                <span class="error-message text-danger" id="name-error"></span>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="form-group">
                <label class="form-control-label">Gradients: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" data-role="tagsinput" id="gradients" placeholder="Enter food gradients">
                <span class="error-message text-danger" id="gradients-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Expire Date: <span class="tx-danger">*</span></label>
                <input type="date" class="form-control" id="expire_date" placeholder="Enter food expire date">
                <span class="error-message text-danger" id="expire-date-error"></span>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="form-group">
                <label class="form-control-label">Collection Address: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="address" placeholder="Enter food collection address">
                <span class="error-message text-danger" id="address-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Date: <span class="tx-danger">*</span></label>
                <input type="date" class="form-control" id="collection_date" placeholder="Enter food collection date">
                <span class="error-message text-danger" id="collection-date-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Time(From): <span class="tx-danger">*</span></label>
                <input type="time" class="form-control" id="start_collection_time" placeholder="Enter food collection start time">
                <span class="error-message text-danger" id="start-collection-time-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Collection Time(To): <span class="tx-danger">*</span></label>
                <input type="time" class="form-control" id="end_collection_time" placeholder="Enter food collection end time">
                <span class="error-message text-danger" id="end-collection-time-error"></span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="description"></textarea>
                <span class="error-message text-danger" id="description-error"></span>
              </div>
            </div>

            <div class="col-lg-4">
              <label class="form-control-label">Upload Food Image:</label><br>
              <label class="custom-file">
                <input type="file" class="custom-file-input" id="image" onChange="mainImageUrl(this)">
                <span class="custom-file-control"></span>
              </label>
              <span class="error-message text-danger" id="image-error"></span>
              <div></div>
              <img src="{{asset('/upload/no_image.jpg')}}" id="mainImage" class="mt-1" style="width: 150px; height: 100px;">
            </div>

            <div class="col-lg-8">
              <label class="form-control-label">Multiple Image:</label><br>
              <label class="custom-file">
                <input type="file" class="custom-file-input" id="multi_image" multiple onChange="multiImageUrl(this)">
                <span class="custom-file-control"></span>
              </label>
              <span class="error-message text-danger" id="multi_image-error"></span>
              <div id="multiImage" class="mt-1" style="display: flex; gap: 5px;">
                <img src="{{asset('/upload/no_image.jpg')}}" id="defaultImage" style="width: 80px; height: 80px;">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="Save()" id="save-btn" class="btn btn-info pd-x-20">Save</button>
        <button class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('foods') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>

<script>
  function mainImageUrl(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#mainImage').attr('src', e.target.result).width(150).height(100);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }


  function multiImageUrl(input) {
    $('#multiImage').empty();

    if (input.files) {
      Array.from(input.files).forEach(file => {
        let reader = new FileReader();
        reader.onload = function (e) {
          $('#multiImage').append(`
            <img src="${e.target.result}" class="mt-1" style="width: 80px; height: 80px; margin-right: 5px;">
          `);
        };
        reader.readAsDataURL(file);
      });
    }
  }

  function resetCreateForm() {
    document.getElementById('save-form').reset();
    $('#mainImage').attr('src', '');
    $('#multiImage').empty();
    $('.summernote').summernote('code', '');
  }


  async function Save() {
    let name = document.getElementById('name').value;
    let gradients = document.getElementById('gradients').value;
    let expire_date = document.getElementById('expire_date').value;
    let address = document.getElementById('address').value;
    let collection_date = document.getElementById('collection_date').value;
    let start_collection_time = document.getElementById('start_collection_time').value;
    let end_collection_time = document.getElementById('end_collection_time').value;
    let description = $('.summernote').summernote('code');
    let image = document.getElementById('image').files[0];
    let multiImages = document.getElementById('multi_image').files;


    document.getElementById('name-error').innerText = '';
    document.getElementById('gradients-error').innerText = '';
    document.getElementById('expire-date-error').innerText = '';
    document.getElementById('address-error').innerText = '';
    document.getElementById('collection-date-error').innerText = '';
    document.getElementById('start-collection-time-error').innerText = '';
    document.getElementById('end-collection-time-error').innerText = '';
    document.getElementById('description-error').innerText = '';
    document.getElementById('image-error').innerText = '';
    document.getElementById('multi_image-error').innerText = '';

    if (name.length === 0) {
      errorToast("Food name required !");
    } 
    else if (gradients.length === 0) {
      errorToast("Food gradients required !");
    } 
    else if (expire_date.length === 0) {
      errorToast("Food expire date required !");
    }
    else if (address.length === 0) {
      errorToast("Food colletion address required !");
    }
    else if (collection_date.length === 0) {
      errorToast("Food colletion date required !");
    }
    else if (start_collection_time.length === 0) {
      errorToast("Food colletion start time required !");
    }
    else if (end_collection_time.length === 0) {
      errorToast("Food colletion end time required !");
    }
    else if (description.length === 0) {
      errorToast("Food description required !");
    }
    else if (!image) {
      errorToast("Food image required !");
    } 
    else if (!multiImages) {
      errorToast("Multiple Food image required !");
    }   
    else {
      let formData = new FormData();
      formData.append('name', name);
      formData.append('gradients', gradients);
      formData.append('expire_date', expire_date);
      formData.append('address', address);
      formData.append('collection_date', collection_date);
      formData.append('start_collection_time', start_collection_time);
      formData.append('end_collection_time', end_collection_time);
      formData.append('description', description);
      formData.append('image', image);

      let multiImages = document.getElementById('multi_image').files;
      Array.from(multiImages).forEach((file, index) => {
          formData.append(`multi_images[${index}]`, file);
      });

      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      };

      try {
        let res = await axios.post("/admin/create", formData, config);
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
              document.getElementById(`${field}-error`).innerText = errorMessages[field][0];
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

