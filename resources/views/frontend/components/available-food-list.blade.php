<section class="shop-page-sec">
    <div class="shop-page-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                    <div class="sidebar">
                        <div class="sidebar-search-area ">
                            <div class="sidebar-title">
                                <h2>Search</h2>
                            </div>
                            <div class="sidebar-widget search-box">
                                <form method="post" action="blog.html">
                                    <div class="form-group">
                                        <input id="search-field" name="search-field" value="" placeholder="Search Here" type="search">
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="categories">
                            <div class="sidebar-title">
                                <h2>Product Categories</h2>
                            </div>
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Business Consulting</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Investment Planning</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Retirement Planning</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Lowyer Consulting</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Online Consulting</a>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-widget popular-tags">
                            <div class="sidebar-title">
                                <h2>Popular tags</h2>
                            </div>

                            <a href="#">Business</a>
                            <a href="#">Investment</a>
                            <a href="#">Planning</a>
                            <a href="#">Chemical</a>
                            <a href="#">Lowyer</a>
                            <a href="#">Consulting</a>
                            <a href="#">Taxation</a>
                            <a href="#">Servicess</a>
                        </div>
                        <div class="product-add">
                            <img src="images/shop/add3.jpg" alt="add" class="img-responsive">
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                            <div class="inner-shop-top-left">
                                <p id="results-count">Showing 1-3 of 9 results</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                            <div class="inner-shop-top-right">
                                <ul>
                                    <li>
                                        <div class="dropdown">
                                            <button data-toggle="dropdown" type="button" class="btn sorting-btn dropdown-toggle" aria-expanded="false">Default Sorting<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="filter-today" data-date="{{ \Carbon\Carbon::today()->toDateString() }}">Today</a></li>
                                                <li><a href="#" class="filter-tomorrow" data-date="{{ \Carbon\Carbon::tomorrow()->toDateString() }}">Tomorrow</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="active">
                                        <a aria-expanded="true" data-toggle="tab" href="#gried-view">
                                            <i class="fa fa-th-large"></i>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a aria-expanded="false" data-toggle="tab" href="#list-view">
                                            <i class="fa fa-list"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="gried-view">
                                 <!-- Grid view content will be inserted here -->
                            </div>
                            <!-- List Style -->
                            <div role="tabpanel" class="tab-pane" id="list-view">
                                 <!-- List view content will be inserted here -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="pagination-design padd-top-40 text-center">
                                <ul id="pagination">
                                    <!-- Pagination links will be dynamically inserted here -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
async function AvailableFoodList(page = 1, date = null, searchQuery = null) {
    try {
        let url = `/available-food-list?page=${page}`;
        if (date) {
            url = `/available-food-list/date/${date}?page=${page}`;
        }

        if (searchQuery) {
            url += `&search=${searchQuery}`;
        }

        const res = await axios.get(url);
        const data = res.data;

        const foodData = data.data.data.filter(food => 
            !searchQuery || food.name.toLowerCase().includes(searchQuery.toLowerCase())
        );

        if (foodData.length === 0) {
            errorToast("No food available matching your search criteria.");
            return;
        }

        const resultsCount = `Showing ${foodData.length} of ${data.data.total} results`;
        document.getElementById('results-count').textContent = resultsCount;

        const gridViewContainer = document.getElementById('gried-view');
        gridViewContainer.innerHTML = foodData.map(food => {
            const isProcessing = food.status === "processing";
            const disabledClass = isProcessing ? "disabled" : "";
            const foodName = food.name;
            const requestBadge = isProcessing ? `<span class="gried-view-badge">processing</span>` : "";
            const foodAddress = isProcessing ? requestBadge : food.address;

            return `
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 ${disabledClass}">
                    <div class="product-box1">
                        <div class="">
                            <a href="/food-details/${food['id']}" ${isProcessing ? 'style="pointer-events: none; opacity: 0.5;"' : ''}>
                                <img class="img-responsive" src="/upload/food/medium/${food.image}" alt="${foodName}">
                            </a>
                        </div>
                        <div class="product-content-holder">
                            <h3><a href="/food-details/${food['id']}" ${isProcessing ? 'style="pointer-events: none; opacity: 0.5;"' : ''}>${foodName}</a></h3>
                            <span>${foodAddress}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        const listViewContainer = document.getElementById('list-view');
        listViewContainer.innerHTML = foodData.map(food => {
            const isProcessing = food.status === "processing";
            const disabledClass = isProcessing ? "disabled" : "";
            const foodName = food.name;
            const requestBadge = isProcessing ? `<span class="list-view-badge">processing</span>` : "";
            const foodAddress = isProcessing ? requestBadge : food.address;

            return `
                <div class="col-lg-12 col-md-12 col-sm-4 col-xs-6 ${disabledClass}">
                    <div class="product-box1">
                        <div class="media">
                            <a class="pull-left" href="/food-details/${food['id']}">
                                <img class="img-responsive" src="/upload/food/medium/${food.image}" alt="${foodName}">
                            </a>
                            <div class="media-body">
                                <div class="product-box2-content">
                                    <h3><a href="/food-details/${food['id']}">${foodName}</a></h3>
                                    <ul>
                                        ${'<li><i aria-hidden="true" class="fa fa-star"></i></li>'.repeat(food.gradients)}
                                    </ul>
                                    <span>${isProcessing ? '<span class="badge badge-small badge-danger">processing</span>' : food.address}</span>
                                    <p>${food.description}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        const paginationContainer = document.querySelector('#pagination');
        paginationContainer.innerHTML = '';

        if (data.data.prev_page_url) {
            paginationContainer.innerHTML += `<li><a href="${data.data.prev_page_url}" class="prev" onclick="return loadPage(event, '${data.data.prev_page_url}')"><span class="fa fa-long-arrow-left"></span></a></li>`;
        } else {
            paginationContainer.innerHTML += `<li><a href="#" class="prev disabled"><span class="fa fa-long-arrow-left"></span></a></li>`;
        }

        data.data.links.forEach(link => {
            if (link.active) {
                paginationContainer.innerHTML += `<li><a href="#" class="active">${link.label}</a></li>`;
            } else if (link.url) {
                paginationContainer.innerHTML += `<li><a href="${link.url}" onclick="return loadPage(event, '${link.url}')">${link.label}</a></li>`;
            } else {
                paginationContainer.innerHTML += `<li><span>${link.label}</span></li>`;
            }
        });

        if (data.data.next_page_url) {
            paginationContainer.innerHTML += `<li><a href="${data.data.next_page_url}" class="next" onclick="return loadPage(event, '${data.data.next_page_url}')"><span class="fa fa-long-arrow-right"></span></a></li>`;
        } else {
            paginationContainer.innerHTML += `<li><a href="#" class="next disabled"><span class="fa fa-long-arrow-right"></span></a></li>`;
        }

    } catch (error) {
        if (error.response) {
            if (error.response.status === 404) {
                errorToast(error.response.data.message || "Food not found.");
            } else if (error.response.status === 500) {
                errorToast("An internal server error occurred. Please try again later.");
            } else {
                errorToast("An unexpected error occurred. Please try again.");
            }
        } else {
            errorToast("Failed to connect to the server. Please check your internet connection.");
        }
    }
}

function loadPage(event, url) {
    event.preventDefault();
    const dateFilter = document.querySelector('.dropdown-menu .active')?.getAttribute('data-date') || null;
    const searchQuery = document.querySelector('input[name="search-field"]').value || null;
    const page = new URL(url).searchParams.get('page');
    AvailableFoodList(page, dateFilter, searchQuery);
}

document.querySelector('.filter-today').addEventListener('click', function(event) {
    event.preventDefault();
    AvailableFoodList(1, this.getAttribute('data-date'));
});

document.querySelector('.filter-tomorrow').addEventListener('click', function(event) {
    event.preventDefault();
    AvailableFoodList(1, this.getAttribute('data-date'));
});

document.querySelector('input[name="search-field"]').addEventListener('input', function() {
    const searchQuery = this.value;
    AvailableFoodList(1, null, searchQuery);
});

AvailableFoodList();

</script>




<style>
    .gried-view-badge {
        background-color: red; 
        color: white!important; 
        font-size: 1em; 
        padding: 0.0em 0.4em;
        border-radius: 0.5rem; 
        font-weight: 600;
        display: inline-block;
        text-decoration: none!important;
    }

    .list-view-badge {
        background-color: red; 
        color: white; 
        font-size: 0.75em; 
        padding: 0.25em 0.4em;
        border-radius: 0.5rem; 
        font-weight: 600;
        display: inline-block;
    }

</style>