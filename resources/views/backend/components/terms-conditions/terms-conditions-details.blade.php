<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Card Body</h6><hr style="border: 1px solid #ddd; margin: 5px 0;">
    <p class="mg-b-20 mg-sm-b-30 mg-t-10">An example of some text within a card body.</p>
</div>

<script>
async function TermsConditionsByType() {
    try {
        let pathArray = window.location.pathname.split('/');
        let type = pathArray[pathArray.length - 1];

        const titleMap = {
            'food_upload': 'Food Upload T&C Information',
            'request_approve': 'Request Approve T&C Information',
            'food_deliver': 'Food Deliver T&C Information'
        };

        const title = titleMap[type] || 'Terms and Conditions Information';

        let res = await axios.get(`/admin/terms-conditions-by-type/${type}`);

        if (res.status === 200) {
            document.querySelector('.card-body-title').innerText = title;
            document.querySelector('.mg-b-20.mg-sm-b-30').innerHTML = res.data.data;
        }
    } catch (error) {
        if (error.response) {
            const status = error.response.status;
            if (status === 400 || status === 404 || status === 500) {
                errorToast(error.response.data.message || 'An error occurred.');
            } else {
                errorToast('An unexpected error occurred.');
            }
        } else {
            errorToast('Network error. Please try again later.');
        }
    }
}

// Call the function on page load
//TermsConditionsByType();
</script>

