<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Site Setting Information</h6>
    <div><a href="" class="btn btn-info mg-b-10 float-right" data-toggle="modal" data-target="#create-modal"><i class="fa fa-plus"></i> Create New</a></div>

    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-10p">Logo</th>
                    <th class="wd-10p">Name</th>
                    <th class="wd-10p">Email</th>
                    <th class="wd-10p">Phone1</th>
                    <th class="wd-10p">Phone2</th>
                    <th class="wd-10p">Address</th>
                    <th class="wd-20p">Description</th>
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
        let res=await axios.get("/admin/setting-list");
        console.log('------',res)
        let tableList=$("#tableList");
        let tableData=$("#datatable1");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function (item, index) {
            let limitedDescription = item['description'].substring(0, 20);
            let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${item['logo'] ? `<img src="/upload/site-setting/${item['logo']}"  width="50" height="50">` : `<img src="/upload/no_image.jpg" width="50" height="50">`}</td>
                        <td>${item['name']}</td>
                        <td>${item['email']}</td>
                        <td>${item['phone1']}</td>
                        <td>${item['phone2']}</td>
                        <td>${item['address']}</td>
                        <td>${limitedDescription}...</td>

                        <td>
                            <button data-path="/upload/site-setting/${item['logo']}" data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                            <button data-path="/upload/site-setting/${item['logo']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                     </tr>`;
            tableList.append(row);
        });

        $('.editBtn').on('click', async function () {
            let id= $(this).data('id');
            let filePath= $(this).data('path');
            await FillUpUpdateForm(id,filePath)
            $("#update-modal").modal('show');
        })

        $('.deleteBtn').on('click',function () {
            let id= $(this).data('id');
            let filePath= $(this).data('path');
            $("#deleteID").val(id);
            $("#deleteFilePath").val(filePath);
            $("#delete-modal").modal('show');
        })

        tableData.DataTable({
            responsive: true
        });
    }
</script>
