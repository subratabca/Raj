<section class="contact-section">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Column-->
            <div class="column col-md-5 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <h2>Our Address</h2>
                    <div class="text">
                        <span id="descriptionContactPage"></span>
                    </div>
                    <div class="contact-info">
                        <ul>
                            <li>
                                <span class="icon flaticon-placeholder"></span>
                                <h3>Address</h3>
                                <span id="addressContactPage"></span>, <span id="cityContactPage"></span>, <span id="countryContactPage"></span>
                            </li>
                            <li>
                                <span class="icon flaticon-envelope-1"></span>
                                <h3>Email</h3>
                                <span id="emailContactPage"></span>
                            </li>
                            <li>
                                <span class="icon flaticon-phone-call"></span>
                                <h3>PHONE</h3>
                                <span id="phone1ContactPage"></span>, <span id="phone2ContactPage"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--Column-->
            <div class="column col-md-7 col-sm-6 col-xs-12">
                <h2>Send Us Message</h2>
                <div class="contact-form default-form">
                    <form id="save-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <input type="text" id="contact-name" placeholder="Name">
                                    <span class="error-message text-danger" id="name-error"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <input type="text" id="contact-email" placeholder="Email">
                                    <span class="error-message text-danger" id="email-error"></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input type="text" id="contact-phone" placeholder="Phone Number">
                                    <span class="error-message text-danger" id="phone-error"></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <textarea id="contact-message" placeholder="Message"></textarea>
                                    <span class="error-message text-danger" id="message-error"></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <button type="button" onclick="Save()" id="save-btn" class="btn-one">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    async function Save() {
        let name = document.getElementById('contact-name').value;
        let email = document.getElementById('contact-email').value;
        let phone = document.getElementById('contact-phone').value;
        let message = document.getElementById('contact-message').value;

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(errorMsg => {
            errorMsg.textContent = '';
        });

        // Validation
        let isValid = true;
        if (name.trim() === '') {
            document.getElementById('name-error').textContent = 'Name is required';
            isValid = false;
        }
        if (email.trim() === '') {
            document.getElementById('email-error').textContent = 'Email is required';
            isValid = false;
        } else if (!isValidEmail(email)) {
            document.getElementById('email-error').textContent = 'Invalid email format';
            isValid = false;
        }
        if (phone.trim() === '') {
            document.getElementById('phone-error').textContent = 'Phone number is required';
            isValid = false;
        }
        if (message.trim() === '') {
            document.getElementById('message-error').textContent = 'Message is required';
            isValid = false;
        }

        if (isValid) {
            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('message', message);
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                },
            };

            try {
                let res = await axios.post("/store-contact-info", formData, config);

                if (res.status === 201 && res.data.status === "success") {
                    successToast(res.data.message);
                    document.getElementById('save-form').reset();
                } else {
                    // Handle unexpected status codes
                    errorToast("Request failed with status: " + res.status);
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    for (const [field, messages] of Object.entries(errors)) {
                        document.getElementById(`${field}-error`).textContent = messages.join(' ');
                    }
                } else {
                    errorToast("An error occurred: " + (error.response?.data?.message || 'Unknown error'));
                }
            }
        }
    }

    function isValidEmail(email) {
        // Simple email validation regex
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
</script>


