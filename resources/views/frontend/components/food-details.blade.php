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
                                <form method="post" action="#">
                                    <div class="form-group">
                                        <input name="search-field" value="" placeholder="Search Here" type="search">
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
                        <div class="best-seller-box">
                            <div class="sidebar-title">
                                <h2>Best Seller</h2>
                            </div>
                            <ul>
                                <li>
                                    <div class="media">
                                        <a href="#" class="pull-left">
                                            <img id="food-img" alt="Popular" src="{{ asset('upload/no_image.jpg') }}" class="img-responsive">
                                        </a>
                                        <div class="media-body">
                                            <h3 class="media-heading" id="food-name2"><a href="#">Product Title Here</a></h3>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
<!--                         <div class="product-add">
                            <img src="images/shop/add3.jpg" alt="add" class="img-responsive">
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="inner-shop-details">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="inner-product-details-left">
                                    <div class="tab-content" id="food-images-tab-content">
                                        <!-- Tab panes will be inserted here by JavaScript -->
                                    </div>
                                    <ul id="food-images-tab-list">
                                        <!-- Tab list items will be inserted here by JavaScript -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <div class="inner-product-details-right">
                                    <h3 id="food-name"></h3>
                                    <h4><strong>Gradients:</strong> <span class="solid-underline" id="gradients"></span></h4>
                                    <p id="food-description"></p>
                        <form id="save-form">
                            <div>
                                <button onclick="Save()" id="save-btn" class="btn btn-primary btn-block">Request Food</button>
                            </div>
                        </form>
                                </div>
                            </div>
                        </div>
<!--                         <div class="product-details-tab-area">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <ul>
                                        <li class="active">
                                            <a href="#description" data-toggle="tab" aria-expanded="false">Description</a>
                                        </li>
                                        <li>
                                            <a href="#review" data-toggle="tab" aria-expanded="false">Review</a>
                                        </li>
                                        <li>
                                            <a href="#information" data-toggle="tab" aria-expanded="false">Information</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="description">
                                            <p>Porem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.</p>
                                        </div>
                                        <div class="tab-pane fade" id="review">
                                            <p>Porem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.</p>
                                        </div>
                                        <div class="tab-pane fade" id="information">
                                            <p>Porem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="featured-products-area2">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="sub-title">Related Products</h3>
                                </div>
                            </div>
                            <div class="related-products-carousel2" id="related-products-carousel2">
                                <!-- Related products will be dynamically inserted here -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let url = window.location.pathname;
    let segments = url.split('/');
    let id = segments[segments.length - 1];

    async function FoodDetailsInfo() {
        try {
            let res = await axios.get("/food-details-info/" + id);
            let data = res.data['data'];
            let relatedData = res.data['relatedData'];
            
            // Update basic food details
            document.getElementById('food-name').innerText = data['name'];
            document.getElementById('food-name2').innerText = data['name'];
            document.getElementById('food-description').innerHTML = data['description'];
            document.getElementById('gradients').innerHTML = data['gradients'];
            document.getElementById('food-img').src = '/upload/food/medium/' + data['image'];

            // Update food images
            let tabContent = '';
            let tabList = '';

            // Add the main food image first
            tabContent += `<div class="tab-pane fade active in" id="main-image">
                <a href="#"><img alt="single-product" src="/upload/food/medium/${data['image']}" class="img-responsive"></a>
            </div>`;

            tabList += `<li class="active">
                <a href="#main-image" data-toggle="tab" aria-expanded="false">
                    <img alt="main-image" src="/upload/food/medium/${data['image']}" class="img-responsive">
                </a>
            </li>`;
        
        // Add the related food images
        data['food_images'].forEach((image, index) => {
            let tabId = 'related' + (index + 1);

            tabContent += `<div class="tab-pane fade" id="${tabId}">
                <a href="#"><img alt="single-product" src="/upload/food/multiple/${image.image}" class="img-responsive"></a>
            </div>`;

            tabList += `<li>
                <a href="#${tabId}" data-toggle="tab" aria-expanded="false">
                    <img alt="related${index + 1}" src="/upload/food/multiple/${image.image}" class="img-responsive">
                </a>
            </li>`;
        });

            document.getElementById('food-images-tab-content').innerHTML = tabContent;
            document.getElementById('food-images-tab-list').innerHTML = tabList;

            // Update related products
            const relatedProductsContainer = document.getElementById('related-products-carousel2');
            let relatedProductsHTML = '';

            relatedData.forEach(food => {
                relatedProductsHTML += `
                    <div class="product-box1">
                        <div class="product-img-holder">
                            <a href="/food-details/${food['id']}"><img class="img-responsive" src="/upload/food/small/${food.image}" alt="product"></a>
                        </div>
                        <div class="product-content-holder">
                            <h3>
                              <a href="/food-details/${food['id']}">${food.name}
                              <p>${food.address}</p>
                              </a>
                            </h3>
                        </div>
                    </div>`;
            });

            relatedProductsContainer.innerHTML = relatedProductsHTML;

        } catch (error) {
            console.error('Error fetching food details:', error);
            errorToast("Failed to fetch food details.");
        }
    }


    async function Save() {
        try {
            let res = await axios.post("/user/store/food-request", { id: id });

            if (res.status === 201) {
                successToast(res.data.message || 'Request success');
                window.location.href = '/';
            } else {
                errorToast(res.data.message || "Request failed");
            }
        } catch (error) {
            if (error.response) {
                if (error.response.status === 401) {
                    window.location.href = '/user/login';
                } else if (error.response.status === 422) {
                    if (error.response.data.message) {
                        errorToast(error.response.data.message);
                    }
                    if (error.response.data.errors) {
                        let errorMessages = error.response.data.errors;
                        for (let field in errorMessages) {
                            if (errorMessages.hasOwnProperty(field)) {
                                errorMessages[field].forEach(msg => errorToast(msg));
                            }
                        }
                    }
                } else if (error.response.status === 404) {
                    errorToast(error.response.data.message || "Resource not found.");
                } else if (error.response.status === 500) {
                    errorToast(error.response.data.error || "An internal server error occurred.");
                } else if (error.response.status === 400) {
                    errorToast(error.response.data.message || "Bad request.");
                    window.location.href = '/';
                } else {
                    errorToast("Request failed!");
                }
            } else {
                errorToast("Request failed!");
            }
            console.error(error);
        }
    }

</script>