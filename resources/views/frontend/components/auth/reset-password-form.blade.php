<section class="registration-section py-5">
    <div class="auto-container">
        <div class="row justify-content-center">
            <!--Column-->
            <div class="col-lg-3"></div>
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card shadow-sm mx-auto">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">New Password Setting Page</h2><hr>
                        <div class="registration-form default-form">
                            <form id="registration-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="login-password">New Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password" placeholder="Enter new password" >
                                            <span class="error-message text-danger" id="password-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="login-password">Confirm Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="cpassword" placeholder="Password" >
                                            <span class="error-message text-danger" id="cpassword-error"></span>
                                        </div>
                                    </div>



                                    <div class="col-md-12 col-sm-12 mb-3">
                                        <button type="button" onclick="ResetPass()" id="register-btn" class="btn btn-primary btn-block">Sign In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
            window.location.href = "/user/sendOtp";
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
            let res = await axios.post("/user/reset-password", { 
                password: password,
                email: email
            });

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
                sessionStorage.clear();
                setTimeout(function () {
                    window.location.href = "/user/login";
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


<style type="text/css">
.registration-section {
    background-color: #f9f9f9;
    padding: 60px 0;
}

.registration-section .card {
    border: none;
    border-radius: 8px;
    background-color: #ffffff;
    max-width: 100%; /* Ensure card does not exceed the container width */
    margin: 0 auto; /* Center the card */
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
