<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Order List Information</h6><br>
    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-10p">Image</th>
                    <th class="wd-10p">Food Name</th>
                    <th class="wd-10p">Order Date</th>
                    <th class="wd-10p">Order Time</th>
                    <th class="wd-10p">Ordered By</th>
                    <th class="wd-10p">Status</th>
                    <th class="wd-20p">Action</th>
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
            let res = await axios.get("/client/orders");
            let tableList = $("#tableList");
            let tableData = $("#datatable1");

            tableData.DataTable().destroy(); 
            tableList.empty(); 

            res.data.data.forEach(function (item, index) {
                let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${item['food']['image'] ? `<img src="/upload/food/small/${item['food']['image']}" width="50" height="50">` : `<img src="/upload/no_image.jpg" width="50" height="50">`}
                            </td>
                            <td>${item['food']['name']}</td>
                            <td>${item['order_date']}</td>
                            <td>${item['order_time']}</td>
                            <td>${item['user']['firstName']}</td>
                            <td>
                                <span class="badge ${item['status'] === 'pending' ? 'bg-danger' : 'bg-success'}">${item['status']}</span>
                            </td>
                            <td>
                                <button data-path="/upload/food/small/${item['food']['image']}" data-id="${item['id']}" class="btn detailsBtn btn-sm btn-outline-primary">Details</button>
                            </td>
                         </tr>`;
                tableList.append(row);
            });

            $('.detailsBtn').on('click', async function () {
                let id = $(this).data('id');
                let filePath = $(this).data('path');
                await FillUpShowForm(id, filePath);
                $("#show-modal").modal('show');
            });
            
            tableData.DataTable({
                responsive: true
            });
        } catch (error) {
            if (error.response) {
                if (error.response.status === 404) {
                    if (error.response.data.message) {
                        errorToast(error.response.data.message);
                    } else {
                        errorToast("Data not found.");
                    }
                }
                else if (error.response.status === 500) {
                    if (error.response.data.error) {
                        errorToast(error.response.data.error);
                    } else {
                        errorToast("An internal server error occurred.");
                    }
                }
                else {
                    errorToast("Request failed!");
                }
            }
            else {
                errorToast("Request failed!");
            }
        }
    }

</script>



