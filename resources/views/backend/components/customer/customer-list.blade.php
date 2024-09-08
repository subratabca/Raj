<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Customer List</h6>
    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-10p">Image</th>
                    <th class="wd-10p">Name</th>
                    <th class="wd-10p">Email</th>
                    <th class="wd-10p">Phone</th>
                    <th class="wd-15p">Registration Date</th>
                    <th class="wd-15p">Registration Time</th>
                </tr>
            </thead>

            <tbody id="tableList">

            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        getList();
    });

    async function getList() {
        try {
            let res = await axios.get("/admin/customers");
            let tableList = $("#tableList");
            let tableData = $("#datatable1");

            tableData.DataTable().destroy();
            tableList.empty();

            res.data.data.forEach(function (item, index) {

                let createdAt = new Date(item['created_at']);

                let registrationDate = createdAt.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                let registrationTime = createdAt.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });

                let fullName = item['lastName'] ? `${item['firstName']} ${item['lastName']}` : item['firstName'];
                let row =`<tr>
                            <td>${index + 1}</td>
                            <td>${item['image'] ? `<img src="/upload/user-profile/small/${item['image']}" width="50" height="50">` : `<img src="/upload/no_image.jpg" width="50" height="50">`}
                            </td>
                            <td>${fullName}</td>
                            <td>${item['email']}</td>
                            <td>${item['mobile']}</td>
                            <td>${registrationDate}</td>
                            <td>${registrationTime}</td>
                         </tr>`;
                tableList.append(row);
            });

            tableData.DataTable({
                responsive: true
            });

        } catch (error) {
            if (error.response) {
                if (error.response.status === 404) {
                    errorToast(error.response.data.message || "Client not found.");
                } else if (error.response.status === 500) {
                    errorToast(error.response.data.error || "An internal server error occurred.");
                } else {
                    errorToast("Request failed!");
                }
            } else {
                errorToast("Request failed!");
            }
        }
    }
    

</script>
