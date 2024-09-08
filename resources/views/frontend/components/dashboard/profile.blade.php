<!--Sidebar Page-->
<div class="sidebar-page-container">
    <!--Tabs Box-->
    <div class="auto-container">
        <div class="row clearfix">

            <!--Sidebar-->
            @include('frontend.components.dashboard.left-sidebar')
            <!--End Sidebar-->

            <!--Content Side-->
            <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="card pd-20 pd-sm-40">
                    <div class="form-layout">
                        <div class="row mg-b-25">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Email:</label>
                                    <input readonly type="email" class="form-control" id="user-email">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" id="user-firstName" placeholder="Enter First Name">
                                    <span class="error-message text-danger" id="firstName-error"></span>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Last Name:</label>
                                    <input type="text" class="form-control" id="user-lastName" placeholder="Enter Last Name">
                                    <span class="error-message text-danger" id="lastName-error"></span>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Mobile Number: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" id="user-mobile" placeholder="Enter Mobile">
                                    <span class="error-message text-danger" id="mobile-error"></span>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-control-label">Upload New Image: <span class="tx-danger">*</span></label><br>
                                        <label class="custom-file">
                                            <input type="file" id="imgUpdate" class="custom-file-input" onChange="mainImgUrl(this)" >
                                            <span class="custom-file-control"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="" id="mainImg" class="mt-1" width="80";height="80">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-layout-footer">
                            <button onclick="onUpdate()" class="btn btn-info mg-r-5">Update</button>
                        </div>
                    </div>
                </div>

            </div>
            <!--End Content Side-->

        </div>
    </div>
</div>
<!--Sidebar Page end-->

<script type="text/javascript">
    function mainImgUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainImg').attr('src',e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } 
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        getProfile();
    });

    async function getProfile() {
        try {
            let res = await axios.get("/user/profile/info");

            if (res.status === 200 && res.data.status === 'success') {
                let data = res.data.data;
                document.getElementById('user-email').value = data.email;
                document.getElementById('user-firstName').value = data.firstName;
                document.getElementById('user-lastName').value = data.lastName;
                document.getElementById('user-mobile').value = data.mobile;
                document.getElementById('mainImg').src = data['image'] ? "/upload/user-profile/small/" + data['image'] : "/upload/no_image.jpg";
            } else {
                errorToast(res.data.message || 'An unexpected error occurred');
            }
        } catch (error) {
            if (error.response) {
                const status = error.response.status;
                if (status === 404) {
                    errorToast(error.response.data.message || 'User not found'); 
                } else if (status === 500) {
                    errorToast(error.response.data.message || 'An error occurred on the server');
                } else {
                    errorToast(error.response.data.message || 'An unexpected error occurred');
                }
            } else {
                errorToast('Network error: ' + error.message);
            }
        }
    }

    async function onUpdate() {
        let firstName = document.getElementById('user-firstName').value;
        let lastName = document.getElementById('user-lastName').value;
        let mobile = document.getElementById('user-mobile').value;
        let image = document.getElementById('imgUpdate').files[0];

        if(firstName.length===0){
            errorToast('First Name is required')
        }
        else if(lastName.length===0){
            errorToast('Last Name is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }
        else{
            let formData = new FormData();
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('mobile', mobile);
            if (image) {
                formData.append('image', image);
            }

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };

            try {
                let res = await axios.post("/user/profile/update", formData, config);

                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    await getProfile();  
                } else {
                    errorToast(res.data.message || 'An unexpected error occurred');
                }
            } catch (error) {
                if (error.response) {
                    const status = error.response.status;
                    if (status === 404) {
                        errorToast(error.response.data.message || 'User not found');
                    } else if (status === 422) {
                        const errors = error.response.data.errors || {};
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorMessage = errors[key][0]; 
                                document.getElementById(`${key}-error`).innerText = errorMessage; 
                            }
                        }
                    } else {
                        errorToast(error.response.data.message || 'An unexpected error occurred');
                    }
                } else {
                    errorToast('Network error: ' + error.message);
                }
            }
        }
    }
</script>
