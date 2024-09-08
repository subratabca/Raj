<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Client <span class="tx-info tx-normal">Panel</span></div>
        <div class="tx-center mg-b-20">Welcome to login page</div>

        <div class="form-group">
            <label>Email Address</label><span class="text-danger">*</span>
            <input type="email" id="email" class="form-control" placeholder="Enter your email">
            <span class="error-message text-danger" id="email-error"></span>
        </div>

        <div class="form-group">
            <label>Password</label><span class="text-danger">*</span>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
            <span class="error-message text-danger" id="password-error"></span>
            <a href="{{ url('/client/sendOtp') }}" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
        </div>

        <button onclick="SubmitLogin()" class="btn btn-info btn-block">Sign In</button>
        <div class="mg-t-40 tx-center">Have not an account? <a href="{{ route('client.registration.page')}}" class="tx-info">Sign Up</a></div>
    </div>
</div>

<script>
    async function SubmitLogin() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        document.getElementById('email-error').innerText = '';
        document.getElementById('password-error').innerText = '';

        if (email.length === 0) {
            errorToast("Email is required");
        } else if (password.length === 0) {
            errorToast("Password is required");
        } else {
            try {
                let res = await axios.post("/client/login", { email: email, password: password });
                if (res.status === 200 && res.data['status'] === 'success') {
                    window.location.href="/client/dashboard";
                } else {
                    errorToast(res.data['message']);
                }
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 401) {
                        errorToast(error.response.data.message);
                    } else if (error.response.status === 422) {
                        const errors = error.response.data.errors;
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorMessage = errors[key][0];
                                document.getElementById(`${key}-error`).innerText = errorMessage;
                            }
                        }
                    } else if (error.response.status === 500) {
                        errorToast(error.response.data.message || "An unexpected error occurred. Please try again later.");
                    } else {
                        errorToast(error.response.data.message || 'Login failed');
                    }
                } else {
                    errorToast('Login failed. Please check your network connection.');
                }
            }
        }
    }
</script>
