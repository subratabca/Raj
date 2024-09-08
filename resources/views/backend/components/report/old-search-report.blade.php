<div class="sl-pagebody">

  <div class="row row-sm mg-t-20">
    <!-- Search by Date -->
    <div class="col-xl-6">
      <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">Search by Date</h6>
        <span><hr style="border: 1px solid #000000 !important;"></span>
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" id="single-date" name="single-date" placeholder="Select a date">
              </div>
            </div>
          </div>
          <div class="form-layout-footer">
            <button class="btn btn-info mg-r-5" onclick="Save('single')">Search</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Search by Date Range -->
    <div class="col-xl-6">
      <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">Search by Date Range</h6>
        <span><hr style="border: 1px solid #000000 !important;"></span>
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Start Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" id="start-date" name="start-date" placeholder="Select start date">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">End Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" id="end-date" name="end-date" placeholder="Select end date">
              </div>
            </div>
          </div>
          <div class="form-layout-footer">
            <button class="btn btn-info mg-r-5" onclick="Save('range')">Search</button>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <div class="row row-sm mg-t-20">
    <div class="col-xl-6">
      <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">Search by date range</h6>

        <div class="form-layout">
          <div class="row mg-b-25">

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" name="firstname" value="John Paul" placeholder="Enter firstname">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Country: <span class="tx-danger">*</span></label>
                <select class="form-control select2" data-placeholder="Choose country">
                  <option label="Choose country"></option>
                  <option value="USA">United States of America</option>
                  <option value="UK">United Kingdom</option>
                  <option value="China">China</option>
                  <option value="Japan">Japan</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-layout-footer">
            <button class="btn btn-info mg-r-5">Submit Form</button>
            <button class="btn btn-secondary">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">Search by date range</h6>

        <div class="form-layout">
          <div class="row mg-b-25">

            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" name="firstname" value="John Paul" placeholder="Enter firstname">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Country: <span class="tx-danger">*</span></label>
                <select class="form-control select2" data-placeholder="Choose country">
                  <option label="Choose country"></option>
                  <option value="USA">United States of America</option>
                  <option value="UK">United Kingdom</option>
                  <option value="China">China</option>
                  <option value="Japan">Japan</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-layout-footer">
            <button class="btn btn-info mg-r-5">Submit Form</button>
            <button class="btn btn-secondary">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  async function Save(criteria) {
    let formData = new FormData();

    // Clear any previous error messages
    document.getElementById('single-date-error').innerText = '';
    document.getElementById('start-date-error').innerText = '';
    document.getElementById('end-date-error').innerText = '';

    // Handling based on the criteria (single or range)
    if (criteria === 'single') {
      let singleDate = document.getElementById('single-date').value;

      if (!singleDate) {
        errorToast("Please select a date!");
        return;
      }

      formData.append('date', singleDate);

    } else if (criteria === 'range') {
      let startDate = document.getElementById('start-date').value;
      let endDate = document.getElementById('end-date').value;

      if (!startDate) {
        errorToast("Please select a start date!");
        return;
      }

      if (!endDate) {
        errorToast("Please select an end date!");
        return;
      }

      formData.append('start_date', startDate);
      formData.append('end_date', endDate);
    }

    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };

    try {
      let res = await axios.post("/admin/order/by/search", formData, config);
      if (res.status === 201) {
        successToast(res.data.message || 'Search completed successfully');
        // You can implement logic to display search results
      } else {
        errorToast(res.data.message || "Search failed");
      }
    } catch (error) {
      if (error.response && error.response.status === 422) {
        let errorMessages = error.response.data.errors;
        for (let field in errorMessages) {
          if (errorMessages.hasOwnProperty(field)) {
            document.getElementById(`${field}-error`).innerText = errorMessages[field][0];
          }
        }
      } else if (error.response && error.response.status === 500) {
        errorToast(error.response.data.error);
      } else {
        errorToast("Search request failed!");
      }
    }
  }
</script>
