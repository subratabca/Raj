<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Admin <span class="tx-info tx-normal">Panel</span></div>
        <div class="tx-center mg-b-20">Welcome to otp page</div>

        <div class="form-group">
            <label>Email Address</label><span class="text-danger">*</span>
            <input type="email" id="email" class="form-control" placeholder="Enter your email">
            <span class="error-message text-danger" id="email-error"></span>
        </div>

        <button onclick="VerifyEmail()"  class="btn btn-info btn-block">Next</button>
    </div>
</div>
</div>

<script>
    async function VerifyEmail() {
        let email = document.getElementById('email').value;
        document.getElementById('email-error').innerText = '';

        if (email.length === 0) {
            errorToast('Please enter your email address');
        } else {
            try {
                let res = await axios.post('/admin/send-otp', { email: email });

                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    sessionStorage.setItem('email', email);
                    setTimeout(function () {
                        window.location.href = '/admin/verifyOtp';
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
                    } else if (error.response.status === 401) {
                        errorToast(error.response.data.message || 'User not found');
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