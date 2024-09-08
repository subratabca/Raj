<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Notification Details</h6>
    <hr style="border: 1px solid #ddd; margin: 5px 0;">
    <p class="mg-b-20 mg-sm-b-30 mg-t-10">Loading notification details...</p>
</div>

<script>
async function NotificationsByType() {
    try {
        let pathArray = window.location.pathname.split('/');
        let id = pathArray[pathArray.length - 1]; 


        let res = await axios.get(`/admin/notification/${id}`);

        if (res.status === 200) {
            let title = res.data.title;
            document.querySelector('.card-body-title').innerText = title;

            if (res.data.food && res.data.admin && res.data.food.user) {
                if(title == 'New Food Upload Notification'){
                    let content = `
                        <p>A new food has been uploaded by <strong>${res.data.food.user.firstName}</strong>. Food details are given below:</p>
                        <p>1. <strong>Food Name:</strong> ${res.data.food.name}</p>
                        <p>2. <strong>Food Gradients:</strong> ${res.data.food.gradients}</p>
                    `;
                    document.querySelector('.mg-b-20.mg-sm-b-30').innerHTML = content;
               }else{
                    let content = `
                        <p>Dear <strong>${res.data.admin.firstName}</strong>, A food has been delivered successfully. Food details are given below:</p>
                        <p>1. <strong>Food Name:</strong> ${res.data.food.name}</p>
                        <p>2. <strong>Food Gradients:</strong> ${res.data.food.gradients}</p>
                    `;
                    document.querySelector('.mg-b-20.mg-sm-b-30').innerHTML = content;
               }
            } else {
                document.querySelector('.mg-b-20.mg-sm-b-30').innerHTML = 'Food details not available';
            }
        }
    } catch (error) {
        let errorMessage = 'An unexpected error occurred.';

        if (error.response) {
            const status = error.response.status;

            if (status === 400) {
                errorMessage = error.response.data.message || 'Food ID not found in the notification data.';
            } else if (status === 404) {
                const serverMessage = error.response.data.status;
                if (serverMessage === 'failed to fetch user') {
                    errorMessage = error.response.data.message || 'User not found.';
                } else if (serverMessage === 'failed to fetch notification') {
                    errorMessage = error.response.data.message || 'Notification not found.';
                } else if (serverMessage === 'failed to fetch food') {
                    errorMessage = error.response.data.message || 'Food details not found.';
                } else {
                    errorMessage = 'Resource not found.';
                }
            } else if (status === 500) {
                errorMessage = error.response.data.message || 'An unexpected error occurred.';
            }
        }

        // Display the error message to the user
        errorToast(errorMessage);
    }
}

// Call the function on page load or as needed
document.addEventListener('DOMContentLoaded', NotificationsByType);
</script>



