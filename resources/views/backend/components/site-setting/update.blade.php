<div id="update-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update Site Setting Information</h6>
        <button type="button" id="modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
        <form id="update-form">
          <div class="row mg-b-25">

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Organization Name: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="nameUpdate" placeholder="Enter organization name">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="emailUpdate" placeholder="Enter email">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Phone1: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="phone1Update" placeholder="Enter phone1">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Phone2: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="phone2Update" placeholder="Enter phone2">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Address: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="addressUpdate" placeholder="Enter address">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">City: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="cityUpdate" placeholder="Enter city">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Country: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="countryUpdate" placeholder="Enter country">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Zip Code: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="zip_codeUpdate" placeholder="Enter zip code">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Facebook Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="facebookUpdate" placeholder="Enter facebook link">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Linkedin Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="linkedinUpdate" placeholder="Enter linkedin link">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Youtube Link: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="youtubeUpdate" placeholder="Enter youtube link">
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote" id="descriptionUpdate" placeholder="Enter description"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Refund Policy: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote1" id="refundUpdate" placeholder="Enter refund policy"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Terms & Condition: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote2" id="termsUpdate" placeholder="Enter terms & condition"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Privacy Policy: <span class="tx-danger">*</span></label>
                <textarea class="form-control summernote3" id="privacyUpdate" placeholder="Enter privacy policy"></textarea>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="row">

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Old Logo:</label><br>
                    <img style="width: 150px; height: 100px;" id="oldImg" src="{{asset('/images/default.jpg')}}"/>
                  </div>
                </div>

                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <label class="form-control-label">Upload New Logo: <span class="tx-danger">*</span></label><br>
                      <label class="custom-file">
                        <input type="file" id="logoUpdate" class="custom-file-input" onChange="mainImgUrl(this)" >

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
        <a href="{{ route('site.settings') }}" class="btn btn-success">Back</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function mainImgUrl(input){
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e){
        $('#mainImg').attr('src',e.target.result).width(200).height(55);
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

    let res=await axios.post("/admin/setting-by-id",{id:id})

    document.getElementById('nameUpdate').value=res.data['name'];
    document.getElementById('emailUpdate').value=res.data['email'];
    document.getElementById('phone1Update').value=res.data['phone1'];
    document.getElementById('phone2Update').value=res.data['phone2'];

    document.getElementById('facebookUpdate').value=res.data['facebook'];
    document.getElementById('linkedinUpdate').value=res.data['linkedin'];
    document.getElementById('youtubeUpdate').value=res.data['youtube'];

    document.getElementById('addressUpdate').value=res.data['address'];
    document.getElementById('cityUpdate').value=res.data['city'];
    document.getElementById('countryUpdate').value=res.data['country'];
    document.getElementById('zip_codeUpdate').value=res.data['zip_code'];

    $('#descriptionUpdate').summernote('code', res.data['description']);
    $('#refundUpdate').summernote('code', res.data['refund']);
    $('#termsUpdate').summernote('code', res.data['terms']);
    $('#privacyUpdate').summernote('code', res.data['privacy']);
  }



  async function update() {

    let name=document.getElementById('nameUpdate').value;
    let email=document.getElementById('emailUpdate').value;
    let phone1=document.getElementById('phone1Update').value;
    let phone2=document.getElementById('phone2Update').value;

    let address=document.getElementById('addressUpdate').value;
    let city=document.getElementById('cityUpdate').value;
    let country=document.getElementById('countryUpdate').value;
    let zip_code=document.getElementById('zip_codeUpdate').value;

    let facebook=document.getElementById('facebookUpdate').value;
    let linkedin=document.getElementById('linkedinUpdate').value;
    let youtube=document.getElementById('youtubeUpdate').value;

    let description= document.getElementById('descriptionUpdate').value;
    let refund= document.getElementById('refundUpdate').value;
    let terms= document.getElementById('termsUpdate').value;
    let privacy= document.getElementById('privacyUpdate').value;
        
    let updateID=document.getElementById('updateID').value;
    let logo = document.getElementById('logoUpdate').files[0];


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
    else {
      $('#update-modal').modal('hide');

      let formData=new FormData();
      formData.append('logo',logo)
      formData.append('id',updateID)
      formData.append('name',name)
      formData.append('email',email)
      formData.append('phone1',phone1)
      formData.append('phone2',phone2)

      formData.append('address',address)
      formData.append('city',city)
      formData.append('country',country)
      formData.append('zip_code',zip_code)

      formData.append('city',city)
      formData.append('country',country)
      formData.append('zip_code',zip_code)

      formData.append('facebook',facebook)
      formData.append('linkedin',linkedin)
      formData.append('youtube',youtube)

      formData.append('description',description)
      formData.append('refund',refund)
      formData.append('terms',terms)
      formData.append('privacy',privacy)

      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      let res = await axios.post("/admin/update-site-setting",formData,config)

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


