    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

      <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Admin <span class="tx-info tx-normal">Panel</span></div>
        <div class="tx-center mg-b-20">Welcome to registration page</div>

        <div class="form-group">
          <label>First Name</label><span class="text-danger">*</span>
          <input type="text" id="firstName" class="form-control" placeholder="Enter your first name">
          <span class="error-message text-danger" id="firstName-error"></span>
        </div>

        <div class="form-group">
          <label>Email Address</label><span class="text-danger">*</span>
          <input type="email" id="email" class="form-control" placeholder="Enter your email">
          <span class="error-message text-danger" id="email-error"></span>
        </div>

        <div class="form-group">
          <label>Password</label><span class="text-danger">*</span>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
          <span class="error-message text-danger" id="password-error"></span>
        </div>

        <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
        <button onclick="Registration()" class="btn btn-info btn-block">Sign Up</button>

        <div class="mg-t-40 tx-center">Already have an account? <a href="{{ route('admin.login.page') }}" class="tx-info">Sign In</a></div>
      </div>
    </div>

<script>
    async function Registration() {
        let email = document.getElementById('email').value;
        let firstName = document.getElementById('firstName').value;
        let password = document.getElementById('password').value;

        document.getElementById('firstName-error').innerText = '';
        document.getElementById('email-error').innerText = '';
        document.getElementById('password-error').innerText = '';

        if(email.length === 0){
            errorToast('Email is required')
        }
        else if(firstName.length === 0){
            errorToast('First Name is required')
        }
        else if(password.length === 0){
            errorToast('Password is required')
        }
        else{
            try {
                let res = await axios.post("/admin/registration", {
                    email: email,
                    firstName: firstName,
                    password: password
                });

                if(res.status === 201 && res.data['status'] === 'success'){
                    successToast(res.data['message']);
                    setTimeout(function (){
                        window.location.href = '/admin/login';
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