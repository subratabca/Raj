<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Admin <span class="tx-info tx-normal">Panel</span></div>
        <div class="tx-center mg-b-20">Welcome to verify otp page</div>

        <div class="form-group">
            <label>ENTER OTP CODE</label><span class="text-danger">*</span>
            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" maxlength="4" pattern="\d{4}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
            <span class="error-message text-danger" id="otp-error"></span>
        </div>

        <button onclick="VerifyOtp()"  class="btn btn-info btn-block">Next</button>
    </div>
</div>
</div>

<script>
    async function VerifyOtp() {
        let otp = document.getElementById('otp').value;
        document.getElementById('otp-error').innerText = '';

        if (otp.length !== 4) {
            errorToast('Invalid OTP');
        } else {
            try {
                let res = await axios.post('/admin/verify-otp', {
                    otp: otp,
                    email: sessionStorage.getItem('email')
                });

                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    setTimeout(() => {
                        window.location.href = '/admin/resetPassword';
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
                        errorToast(error.response.data.message || 'Unauthorized');
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
