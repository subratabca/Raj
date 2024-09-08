<section class="about-section sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="left-side">
                    <img src="images/resource/businessman-2.png" alt="images" id="image"/>
                </div>
            </div>
            <div class="col-sm-7">
                <h4><span id="title"></span></h4>
                <div class="aboutsrv">
                    <p><span id="description"></span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    async function AboutInfo() {
        try {
            let res = await axios.get("/about-page-info");

            if (res.status === 200 && res.data.status === "success") {
                const firstData = res.data.data;

                const image = "{{ asset('upload/about/') }}" + "/" + firstData.image;
                document.getElementById('image').src = image;

                document.getElementById('title').innerText = firstData.title;

                const tempElement = document.createElement('div');
                tempElement.innerHTML = firstData.description;

                const descriptionText = tempElement.textContent;
                document.getElementById('description').innerText = descriptionText;

            } else {
                errorToast("Error fetching about page data: " + res.data.message);
            }

        } catch (error) {
            if (error.response) {
                if (error.response.status === 404) {
                    errorToast("Data not found: " + error.response.data.message);
                } else if (error.response.status === 500) {
                    errorToast("An error occurred on the server: " + error.response.data.message);
                } else {
                    errorToast("An unknown error occurred: " + error.response.data.message);
                }
            } else {
                errorToast("Failed to connect to the server");
            }
        }
    }
    window.onload = AboutInfo;
</script>








