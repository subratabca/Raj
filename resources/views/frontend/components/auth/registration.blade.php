<section class="registration-section py-5">
    <div class="auto-container">
        <div class="row justify-content-center">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card shadow-sm mx-auto">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Create Your Account</h2><hr>
                        <div class="registration-form default-form">
                            <form id="registration-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="registration-firstName">First Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="registration-firstName" placeholder="First Name">
                                            <span class="error-message text-danger" id="firstName-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="registration-email">Email Address: <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="registration-email" placeholder="Email">
                                            <span class="error-message text-danger" id="email-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="registration-password">Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="registration-password" placeholder="Password">
                                            <span class="error-message text-danger" id="password-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" onclick="Register()" id="register-btn" class="btn btn-primary btn-block">REGISTER</button>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mt-3 text-center">
                                        <div class="mg-t-40 tx-center">Already have an account? <a href="{{ route('login.page') }}" class="tx-info">Sign In</a></div>
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
async function Register() {
    let email = document.getElementById('registration-email').value;
    let firstName = document.getElementById('registration-firstName').value;
    let password = document.getElementById('registration-password').value;

    document.getElementById('firstName-error').innerText = '';
    document.getElementById('email-error').innerText = '';
    document.getElementById('password-error').innerText = '';

    if(firstName.length === 0){
        errorToast('First Name is required');
    }
    else if(email.length === 0){
        errorToast('Email is required');
    }
    else if(password.length === 0){
        errorToast('Password is required');
    }
    else{
        try {
            let res = await axios.post("/user/registration", {
                email: email,
                firstName: firstName,
                password: password
            });

            if(res.status === 201 && res.data['status'] === 'success'){
                successToast(res.data['message']);
                setTimeout(function (){
                    window.location.href = '/user/login';
                }, 1000);
            }
            else{
                errorToast(res.data['message']);
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        const errorMessage = errors[key][0]; 
                        document.getElementById(`${key}-error`).innerText = errorMessage; 
                    }
                }
            } else {
                errorToast(error.response ? error.response.data.message : 'Registration failed');
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
