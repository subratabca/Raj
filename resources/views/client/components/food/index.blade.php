<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Food List</h6>
    <div><a href="" class="btn btn-info mg-b-10 float-right" data-toggle="modal" data-target="#create-modal"><i class="fa fa-plus"></i> Upload New food</a></div>

    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">Sl</th>
                    <th class="wd-10p">Image</th>
                    <th class="wd-10p">Food Name</th>
                    <th class="wd-15p">Expire Date</th>
                    <th class="wd-15p">Collection Date</th>
                    <th class="wd-15p">Collection Time</th>
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
            let res = await axios.get("/client/index");
            let tableList = $("#tableList");
            let tableData = $("#datatable1");

            tableData.DataTable().destroy();
            tableList.empty();

            res.data.data.forEach(function (item, index) {
                let parser = new DOMParser();
                let doc = parser.parseFromString(item['description'], 'text/html');
                let limitedDescription = doc.body.textContent.substring(0, 20) + '...';

                let formattedExpireDate = formatDate(item['expire_date']);
                let formattedCollectionDate = formatDate(item['collection_date']);

                let formattedStartTime = formatTime(item['start_collection_time']);
                let formattedEndTime = formatTime(item['end_collection_time']);

                let row = `<tr>
                <td>${index + 1}</td>
                <td>${item['image'] ? `<img src="/upload/food/small/${item['image']}" width="50" height="50">` : `<img src="/upload/no_image.jpg" width="50" height="50">`}
                </td>
                <td>${item['name']}</td>
                <td>${formattedExpireDate}</td>
                <td>${formattedCollectionDate}</td>
                <td>${formattedStartTime} - ${formattedEndTime}</td>
                <td>
                <span class="badge ${
                    item['status'] === 'pending' ? 'bg-danger' :
                    item['status'] === 'published' ? 'bg-primary' :
                    'bg-success'
                }">
                ${item['status']}
                </span>
                </td>
                <td>
                <button data-path="/upload/food/small/${item['image']}" data-id="${item['id']}" class="btn detailsBtn btn-sm btn-outline-primary">Details</button>
                <button data-path="/upload/food/small/${item['image']}" data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                <button data-path="/upload/food/small/${item['image']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>

                <button data-id="${item['id']}" class="btn multiImgBtn btn-sm btn-outline-success">Edit Multi Image</button>
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

            $('.editBtn').on('click', async function () {
                let id = $(this).data('id');
                let filePath = $(this).data('path');
                await FillUpUpdateForm(id, filePath);
                $("#update-modal").modal('show');
            });

            $('.multiImgBtn').on('click', async function () {
                let id = $(this).data('id');
                await FillMultiImgForm(id);
                $("#multi-image-modal").modal('show');
            })

            $('.deleteBtn').on('click', function () {
                let id = $(this).data('id');
                let filePath = $(this).data('path');
                $("#deleteID").val(id);
                $("#deleteFilePath").val(filePath);
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

    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
    
    function formatTime(timeString) {
        let date = new Date('1970-01-01T' + timeString + 'Z');
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
