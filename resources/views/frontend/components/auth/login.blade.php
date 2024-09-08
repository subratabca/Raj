<section class="registration-section py-5">
    <div class="auto-container">
        <div class="row justify-content-center">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card shadow-sm mx-auto">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Login Your Account</h2><hr>
                        <div class="registration-form default-form">
                            <form id="registration-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="login-email">Email Address: <span class="text-danger">*</span></label>
                                            <input type="email" id="login-email" placeholder="Email" class="form-control">
                                            <span class="error-message text-danger" id="email-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="login-password">Password: <span class="text-danger">*</span></label>
                                            <input type="password" id="login-password" placeholder="Password" class="form-control">
                                            <span class="error-message text-danger" id="password-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mt-3 mb-3">
                                        <a href="{{ url('/user/sendOtp') }}" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-3">
                                        <button type="button" onclick="SubmitLogin()" id="register-btn" class="btn btn-primary btn-block">Sign In</button>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mt-3 text-center">
                                        <div class="mg-t-40 tx-center">Don't have an account? <a href="{{ route('register.page') }}" class="tx-info">Sign Up</a></div>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ url('/auth/facebook') }}" class="btn btn-primary">Login with Facebook</a>
                            <a href="{{ url('/auth/google') }}" class="btn btn-danger">Login with Google</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    async function SubmitLogin() {
        let email = document.getElementById('login-email').value;
        let password = document.getElementById('login-password').value;

        document.getElementById('email-error').innerText = '';
        document.getElementById('password-error').innerText = '';

        if (email.length === 0) {
            errorToast("Email is required");
        } else if (password.length === 0) {
            errorToast("Password is required");
        } else {
            try {
                let res = await axios.post("/user/login", { email: email, password: password });
                if (res.status === 200 && res.data['status'] === 'success') {
                    //window.location.href = '/';
                    window.location.href = res.data['redirect']; 
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

<style type="text/css">
    .registration-section {
        background-color: #f9f9f9;
        padding: 60px 0;
    }

    .registration-section .card {
        border: none;
        border-radius: 8px;
        background-color: #ffffff;
        max-width: 100%; 
        margin: 0 auto;
    }

    .registration-section .card-body {
        padding: 30px;
    }

    .registration-section .form-control {
        border-radius: 50px;
        padding: 15px;
    }

    .registration-section .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 50px;
        padding: 15px;
        font-size: 16px;
    }

    .registration-section .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .registration-section h2 {
        font-weight: 700;
        color: #333;
    }

    .mg-t-40 {
        margin-top: 40px;
    }

    .mb-3 {
        margin-bottom: 1rem; /* Bootstrap class for margin-bottom */
    }
</style>
