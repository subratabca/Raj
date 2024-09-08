<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Client <span class="tx-info tx-normal">Panel</span></div>
        <div class="tx-center mg-b-20">Welcome to new password setting page</div>

        <div class="form-group">
            <label>New Password</label><span class="text-danger">*</span>
            <input type="password" id="password" class="form-control" placeholder="Enter new password">
            <span class="error-message text-danger" id="password-error"></span>
        </div>

        <div class="form-group">
            <label>Confirm Password</label><span class="text-danger">*</span>
            <input type="password" id="cpassword" class="form-control" placeholder="Enter confirm password">
            <span class="error-message text-danger" id="cpassword-error"></span>
        </div>

        <button onclick="ResetPass()" class="btn btn-info btn-block">Next</button>
    </div>
</div>

<script>
    async function ResetPass() {
        let password = document.getElementById('password').value;
        let cpassword = document.getElementById('cpassword').value;
        let email = sessionStorage.getItem('email');

        document.getElementById('password-error').innerText = '';
        document.getElementById('cpassword-error').innerText = '';

        if (!email) {
            errorToast('Please provide email for forgot password');
            setTimeout(function () {
                window.location.href = "/client/sendOtp";
            }, 1000);
            return;
        }

        if (password.length === 0) {
            document.getElementById('password-error').innerText = 'Password is required';
        } else if (cpassword.length === 0) {
            document.getElementById('cpassword-error').innerText = 'Confirm Password is required';
        } else if (password !== cpassword) {
            document.getElementById('cpassword-error').innerText = 'Password and Confirm Password must be the same';
        } else {
            try {
                let res = await axios.post("/client/reset-password", { 
                    password: password,
                    email: email
                });

                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    sessionStorage.clear();
                    setTimeout(function () {
                        window.location.href = "/client/login";
                    }, 1000);
                } else {
                    errorToast(res.data['message']);
                }
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        const errors = error.response.data.errors;
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorMessage = errors[key][0];
                                document.getElementById(`${key}-error`).innerText = errorMessage;
                            }
                        }
                    } else if (error.response.status === 404) {
                        errorToast(error.response.data.message || 'User not found');
                    } else if (error.response.status === 500) {
                        errorToast(error.response.data.message || 'Something went wrong. Please try again later.');
                    } else {
                        errorToast(error.response.data.message || 'An unexpected error occurred.');
                    }
                } else {
                    errorToast('An unexpected error occurred.');
                }
            }
        }
    }
</script>