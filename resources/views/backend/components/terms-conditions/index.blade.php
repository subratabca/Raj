<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Terms & Conditions Information</h6>
    <div><a href="" class="btn btn-info mg-b-10 float-right" data-toggle="modal" data-target="#create-modal"><i class="fa fa-plus"></i> Create New</a></div>

    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-20p">Food Upload</th>
                    <th class="wd-20p">Request Approve</th>
                    <th class="wd-20p">Food Deliver</th>
                    <th class="wd-15p">Action</th>
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
            let res = await axios.get("/admin/terms-conditions-list");
            let tableList = $("#tableList");
            let tableData = $("#datatable1");
            let createButton = $(".btn-info");

            tableData.DataTable().destroy();
            tableList.empty();

            if (res.data.data.length > 0) {
                createButton.hide(); 
            } else {
                createButton.show();
            }

            res.data.data.forEach(function (item, index) {
                let limitedFoodUpload = item['food_upload'].substring(0, 40);
                let limitedRequestApprove = item['request_approve'].substring(0, 40);
                let limitedFoodDeliver = item['food_deliver'].substring(0, 40);
                let row = `<tr>
                            <td>${index + 1}</td>
                            <td><a href="/admin/terms-conditions/food_upload">${limitedFoodUpload}...</a></td>
                            <td><a href="/admin/terms-conditions/request_approve">${limitedRequestApprove}...</a></td>
                            <td><a href="/admin/terms-conditions/food_deliver">${limitedFoodDeliver}...</a></td>
                            <td>
                                <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                                <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                            </td>
                         </tr>`;
                tableList.append(row);
            });

            $('.editBtn').on('click', async function () {
                let id = $(this).data('id');
                await FillUpUpdateForm(id);
                $("#update-modal").modal('show');
            });

            $('.deleteBtn').on('click', function () {
                let id = $(this).data('id');
                $("#deleteID").val(id);
                $("#delete-modal").modal('show');
            });

            tableData.DataTable({
                responsive: true
            });

        } catch (error) {
            if (error.response) {
                if (error.response.status === 404) {
                    errorToast(error.response.data.message || "Data not found.");
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
