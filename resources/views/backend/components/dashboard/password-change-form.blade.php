<div class="card pd-20 pd-sm-40">
  <h6 class="card-body-title">Update Password</h6><br>

  <div class="form-layout">
      <div class="row mg-b-25">

        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">Old Password: <span class="tx-danger">*</span></label>
            <input type="password" class="form-control" id="oldpassword">
            <span class="error-message text-danger" id="oldpassword-error"></span>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">New Password: <span class="tx-danger">*</span></label>
            <input type="password" class="form-control" id="newpassword">
            <span class="error-message text-danger" id="newpassword-error"></span>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">Confirm Password: <span class="tx-danger">*</span></label>
            <input type="password" class="form-control" id="cpassword">
            <span class="error-message text-danger" id="cpassword-error"></span>
          </div>
        </div>

      </div>
      <div class="form-layout-footer">
        <button onclick="onUpdate()" class="btn btn-info mg-r-5">Update</button>
      </div>
  </div>
</div>


<script>
    async function onUpdate() {
        let oldpassword = document.getElementById('oldpassword').value;
        let newpassword = document.getElementById('newpassword').value;
        let cpassword = document.getElementById('cpassword').value;

        document.getElementById('oldpassword-error').innerText = '';
        document.getElementById('newpassword-error').innerText = '';
        document.getElementById('cpassword-error').innerText = '';

        if (oldpassword.length === 0) {
            document.getElementById('oldpassword-error').innerText = 'Old Password is required';
        } else if (newpassword.length === 0) {
            document.getElementById('newpassword-error').innerText = 'New Password is required';
        } else if (cpassword.length === 0) {
            document.getElementById('cpassword-error').innerText = 'Confirm Password is required';
        } else if (newpassword !== cpassword) {
            document.getElementById('newpassword-error').innerText = 'New Password and Confirm Password must be the same';
        } else {
            try {
                let res = await axios.post("/admin/password/update", {
                    oldpassword: oldpassword,
                    newpassword: newpassword,
                    newpassword_confirmation: cpassword
                });

                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = "/admin/update/password";
                    }, 2000); 
                } else {
                    errorToast(res.data.message || 'An unexpected error occurred');
                }
            } catch (error) {
                if (error.response) {
                    const status = error.response.status;
                    if (status === 404) {
                        errorToast(error.response.data.message || 'User not found');
                    } else if (status === 400) {
                        const message = error.response.data.message || 'Bad request (400)';
                        document.getElementById('oldpassword-error').innerText = message;
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
                    errorToast('An error occurred: ' + error.message);
                }
            }
        }
    }
</script>




