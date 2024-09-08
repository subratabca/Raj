<div id="multi-image-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update Multi Image</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div id="multi-images-container"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function renderMultiImages(foodImages) {
    const container = document.getElementById('multi-images-container');
    container.innerHTML = '';

    foodImages.forEach((image, index) => {
      const imgIndex = index + 1;
      const imgElement = `
        <div class="row mg-b-25">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Old Related Image:</label><br>
                  <img style="width: 150px; height: 100px;" id="oldMultiImg${imgIndex}" src="{{asset('/upload/food/multiple/${image.image}')}}"/>
                </div>
              </div>

              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-6">
                    <label class="form-control-label">Upload New Related Food Image: <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" id="imgUpdate${imgIndex}" class="custom-file-input" onChange="updateMultiImgUrl(this, ${imgIndex})" >
                      <span class="custom-file-control"></span>
                    </label>
                    <span class="error-message text-danger" id="update_image-error${imgIndex}"></span>
                  </div>
                  <div class="col-lg-6">
                    <img src="{{ asset('/upload/no_image.jpg') }}" id="updateMultiImg${imgIndex}" class="mt-1" width="150" height="100">
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <button type="button" onclick="updateMultiImg(${image.id}, ${imgIndex})" id="update-multi-img-btn" class="btn btn-info pd-x-20">Update</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                <a href="{{ route('client.foods') }}" class="btn btn-success">Back</a>
              </div>
            </div>
          </div>
        </div><hr>
      `;

      container.insertAdjacentHTML('beforeend', imgElement);
    });
  }

  function updateMultiImgUrl(input, index) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(`updateMultiImg${index}`).setAttribute('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  async function FillMultiImgForm(id){
    $('#multi-images-container').empty(); // Clear previous images
    try {
      let res = await axios.post("/client/edit/", {id: id});
      if (res.data && res.data.data.food_images) {
        renderMultiImages(res.data.data.food_images);
      }
    } catch (error) {
      console.error('Error fetching food information:', error);
    }
  }

  async function updateMultiImg(imageId, imgIndex) {
    let formData = new FormData();
    formData.append('id', imageId);
    const imgUpdateInput = document.getElementById(`imgUpdate${imgIndex}`);
    if (imgUpdateInput.files && imgUpdateInput.files[0]) {
      formData.append('image', imgUpdateInput.files[0]);
    } else {
      errorToast("Please select an image to update");
      return;
    }

    const config = {
      headers: {
        'content-type': 'multipart/form-data'
      }
    };

    try {
      let res = await axios.post("/client/update-multi-image", formData, config);
      if (res.status === 200) {
        successToast(res.data.message || 'Update Success');
        document.getElementById('update-form').reset();
        $('#multi-image-modal').modal('hide');
        await getList(); 
      } else {
        errorToast(res.data.message || "Request failed");
      }
    } catch (error) {
      if (error.response && error.response.status === 422) {
        let errorMessages = error.response.data.errors;
        for (let field in errorMessages) {
          if (errorMessages.hasOwnProperty(field)) {
            document.getElementById(`update_${field}-error${imgIndex}`).innerText = errorMessages[field][0];
          }
        }
      } else if (error.response && error.response.status === 500) {
        errorToast(error.response.data.error);
      } else {
        errorToast("Request failed!");
      }
    }
  }
</script>


