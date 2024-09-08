<div id="update-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update About Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div class="row mg-b-25">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="titleUpdate" placeholder="Enter Title">
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="descriptionUpdate" placeholder="Enter Description"></textarea>

              </div>
            </div>

            <div class="col-lg-12">
              <div class="row">

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Old Image:</label><br>
                    <img style="width: 150px; height: 100px;" id="oldImg" src="{{asset('/images/default.jpg')}}"/>
                  </div>
                </div>

                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <label class="form-control-label">Upload New Image: <span class="tx-danger">*</span></label><br>
                      <label class="custom-file">
                        <input type="file" id="imgUpdate" class="custom-file-input" onChange="mainImgUrl(this)" >

                        <input type="text" class="d-none" id="updateID">
                        <input type="text" class="d-none" id="filePath">

                        <span class="custom-file-control"></span>
                      </label>
                    </div>
                    <div class="col-lg-6">
                      <img src="" id="mainImg" class="mt-1" width="120";height="80">
                    </div>
                  </div>
                </div>

              </div> 
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button onclick="update()" id="update-btn" class="btn btn-info pd-x-20">Update</button>
        <button  class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
        <a href="{{ route('abouts') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function mainImgUrl(input){
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e){
        $('#mainImg').attr('src',e.target.result).width(80).height(80);
      };
      reader.readAsDataURL(input.files[0]);
    }
  } 
</script>


<script>

  async function FillUpUpdateForm(id,filePath){

    document.getElementById('updateID').value=id;
    document.getElementById('filePath').value=filePath;
    document.getElementById('oldImg').src=filePath;
    $('#mainImg').attr('src', '/upload/no_image.jpg')

    let res=await axios.post("/admin/about-by-id",{id:id})

    document.getElementById('titleUpdate').value=res.data['title'];
    $('#descriptionUpdate').summernote('code', res.data['description']);
  }



  async function update() {

    let titleUpdate=document.getElementById('titleUpdate').value;
    let descriptionUpdate = document.getElementById('descriptionUpdate').value;
    let updateID=document.getElementById('updateID').value;
    let filePath=document.getElementById('filePath').value;
    let imgUpdate = document.getElementById('imgUpdate').files[0];


    if (titleUpdate.length === 0) {
      errorToast("Title Required !")
    }
    else if(descriptionUpdate.length===0){
      errorToast("Description Required !")
    }

    else {
      $('#update-modal').modal('hide');

      let formData=new FormData();
      formData.append('img',imgUpdate)
      formData.append('id',updateID)
      formData.append('title',titleUpdate)
      formData.append('description',descriptionUpdate)
      formData.append('file_path',filePath)

      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      let res = await axios.post("/admin/update-about",formData,config)

      if(res.status===200 && res.data===1){
        successToast('Request completed');
        document.getElementById("update-form").reset();
        await getList();
      }
      else{
        errorToast("Request fail !")
      }
    }
  }
</script>


