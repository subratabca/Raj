<div class="sidebar-page-container">
    <!-- Tabs Box -->
    <div class="auto-container">
        <div class="row clearfix">

            <!-- Sidebar -->
            @include('frontend.components.dashboard.left-sidebar')
            <!-- End Sidebar -->

            <!-- Content Side -->
            <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="card pd-20 pd-sm-40">
                    <h4>Food Details</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="wd-5p">Sl</th>
                                <th class="wd-10p">Image</th>
                                <th class="wd-10p">Food Name</th>
                                <th class="wd-10p">Food Gradients</th>
                                <th class="wd-10p">Provider Name</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-20p">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Content Side -->
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    getList();
});

async function getList() {
    try {
        let res = await axios.get("/user/orders");

        let tableList = $("#tableList");
        tableList.empty(); 
 

        res.data.data.forEach(function (item, index) {
            let formattedDate = formatDate(item.created_at);
            let formattedTime = formatTime(item.created_at);

            let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${item.food.image ? 
                            `<img src="/upload/food/small/${item.food.image}" width="50" height="50">` : 
                            `<img src="/upload/no_image.jpg" width="50" height="50">`}
                        </td>
                        <td>${item.food.name}</td>
                        <td>${item.food.gradients}</td>
                        <td>${item.food.user.firstName}</td>
                        <td>
                            <span class="badge ${item.status === 'pending' ? 'bg-danger' : 'bg-success'}">
                                ${item.status}
                            </span>
                        </td>
                        <td>
                            <a href="/user/order-details/${item['id']}" class="btn btn-sm btn-info">Details</a>
                        </td>
                     </tr>`;
            tableList.append(row);
        });
    } catch (error) {
        console.error("Error fetching order data:", error);
    }
}

function formatDate(dateString) {
    let date = new Date(dateString);
    let months = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"];

    let day = date.getUTCDate();
    let month = months[date.getUTCMonth()];
    let year = date.getUTCFullYear();

    return `${day} ${month} ${year}`;
}

function formatTime(dateString) {
    let date = new Date(dateString);
    let hours = date.getUTCHours();
    let minutes = date.getUTCMinutes();
    let seconds = date.getUTCSeconds();

    let amPm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; 

    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    return `${hours}:${minutes}:${seconds} ${amPm}`;
}

</script>
