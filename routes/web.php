<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Middleware\AdminTokenVerificationMiddleware;
use App\Http\Middleware\ClientTokenVerificationMiddleware;

// Admin
use App\Http\Controllers\Backend\Auth\AdminAuthController;
use App\Http\Controllers\Backend\Profile\AdminProfileController; 
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FoodController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Backend\ClientListController;
use App\Http\Controllers\Backend\CustomerListController;

use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\TermsConditionsController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminNotificationController;
use App\Http\Controllers\Backend\AdminReportController;

// Client
use App\Http\Controllers\Client\Auth\ClientAuthController;
use App\Http\Controllers\Client\Profile\ClientProfileController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ClientFoodController;
use App\Http\Controllers\Client\ClientOrderController;
use App\Http\Controllers\Client\ClientNotificationController;
use App\Http\Controllers\Client\ClientReportController;

// Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\SocialAuthController;
use App\Http\Controllers\Frontend\NotificationController;


Route::prefix('auth')->group(function () {
    Route::get('/{provider}', [SocialAuthController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
});


// Frontend API Routes
Route::prefix('user')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/registration','RegistrationPage')->name('register.page');
        Route::post('/registration','Registration');

        Route::get('/login','LoginPage')->name('login.page');
        Route::post('/login','Login');

        Route::get('/sendOtp','SendOtpPage');
        Route::post('/send-otp','SendOTPCode');

        Route::get('/verifyOtp','VerifyOTPPage');
        Route::post('/verify-otp','VerifyOTP');

        Route::get('/resetPassword','ResetPasswordPage');
        Route::post('/reset-password','ResetPassword');
    });
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/','HomePage')->name('home');
    Route::get('/setting-list', 'SettingList');
    Route::get('/slider-list','SliderList');
    Route::get('/food-list', 'FoodList');
    Route::get('/food-list/date/{date}','getAvailableFoodByDate');
    Route::get('/search-food','searchFood');
});

Route::controller(PagesController::class)->group(function () {
    Route::get('/about-us','AboutPage')->name('about');
    Route::get('/about-page-info','AboutPageInfo');

    //Route::get('/available-food','AvailableFoodPage')->name('available.food');
    //Route::get('/available-food-list/','AvailableFoodList');
    //Route::get('/available-food-list/date/{date}','getAvailableFoodByDate');
    //Route::get('/search-food','searchFood');

    Route::get('/food-details/{id}','FoodDetailsPage')->name('food.by.id');
    Route::get('/food-details-info/{id}','FoodDetailsInfo');

    Route::get('/contact-us','ContactPage')->name('contact.us.page');
    Route::post('/store-contact-info','StoreContactInfo');
});

Route::prefix('user')->middleware([TokenVerificationMiddleware::class])->group(function () {
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/profile','ProfilePage')->name('user.profile');
        Route::get('/profile/info','Profile');
        Route::post('/profile/update','UpdateProfile');
        Route::get('/update/password','PasswordPage')->name('user.update.password');
        Route::post('/password/update','UpdatePassword');
    });

    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/dashboard','DashboardPage')->name('user.dashboard');
        Route::get("/dashboard-order-details",'DashboardOrderDetailsInfo');
        Route::get('/logout','Logout')->name('logout');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::post('/store/food-request', 'StoreFoodRequest');
        Route::get('order-list', 'OrderPage')->name('orders');
        Route::get("/orders",'OrderList');
        Route::get("/order-details/{id}",'OrderDetailsPage');
        Route::get("/order-details-info/{id}",'OrderDetailsInfo');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification/info', 'NotificationList')->name('notification');
        Route::post('/markAsRead', 'MarkAsRead')->name('markRead');
        Route::get('/markAsRead/notification/{notificationId}', 'MarkAsReadByType')->name('MarkAsReadById');
        Route::get('/notification/{notificationId}', 'NotificationDetailsById');
        Route::get('/delete/notification/{notificationId}', 'deleteNotification');
    });

});
    

// Admin API Routes
Route::prefix('admin')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/registration','RegistrationPage')->name('admin.registration.page');
        Route::post('/registration','Registration');

        Route::get('/login','LoginPage')->name('admin.login.page');
        Route::post('/login','Login');

        Route::get('/sendOtp','SendOtpPage');
        Route::post('/send-otp','SendOTPCode');

        Route::get('/verifyOtp','VerifyOTPPage');
        Route::post('/verify-otp','VerifyOTP');

        Route::get('/resetPassword','ResetPasswordPage');
        Route::post('/reset-password','ResetPassword');
    });
});

Route::prefix('admin')->middleware([AdminTokenVerificationMiddleware::class])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard','DashboardPage')->name('admin.dashboard');
        Route::get('/logout','Logout')->name('admin.logout');
    });

    Route::controller(AdminProfileController::class)->group(function () {
        Route::get('/update/profile','ProfilePage');
        Route::get('/profile/info','Profile');
        Route::post('/profile/update','UpdateProfile');
        Route::get('/update/password','PasswordPage');
        Route::post('/password/update','UpdatePassword');
    });

    Route::controller(FoodController::class)->group(function () {
        Route::get('food-page', 'FoodPage')->name('foods');
        Route::get("/index",'index');
        Route::post("/create",'create');
        Route::get("/show/{id}",'show');
        Route::post("/edit",'edit');
        Route::post("/update",'update');
        Route::post("/delete",'delete');
        Route::post("/update/status",'status');
    });

    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('order-list', 'OrderPage')->name('admin.orders');
        Route::get("/orders",'OrderList');
        Route::get("/order-details/{id}",'OrderDetails');
    });

    Route::controller(ClientListController::class)->group(function () {
        Route::get('client-list', 'ClientPage')->name('clients');
        Route::get("/clients",'ClientList');
    });

    Route::controller(CustomerListController::class)->group(function () {
        Route::get('customer-list', 'CustomerPage')->name('customers');
        Route::get("/customers",'CustomerList');
    });

    Route::controller(SiteSettingController::class)->group(function () {
        Route::get('setting-page', 'SettingPage')->name('site.settings');
        Route::get("/setting-list",'SettingList');
        Route::post("/create-site-setting",'SettingCreate');
        Route::post("/setting-by-id",'SettingByID');
        Route::post("/update-site-setting",'UpdateSetting');
        Route::post("/delete-site-setting",'DeleteSetting');
    });

    Route::controller(TermsConditionsController::class)->group(function () {
        Route::get('terms-conditions-page', 'TermsConditionsPage')->name('terms.conditions');
        Route::get("/terms-conditions-list",'TermsConditionsList');
        Route::post("/create-terms-conditions",'TermsConditionsCreate');
        Route::post("/terms-conditions-by-id",'TermsConditionsByID');
        Route::post("/update-terms-conditions",'UpdateTermsConditions');
        Route::post("/delete-terms-conditions",'DeleteTermsConditions');

        Route::get('/terms-conditions/{type}','TermsConditionsDetailsPage');
        Route::get('/terms-conditions-by-type/{type}','TermsConditionsByType');
    });

    Route::controller(SliderController::class)->group(function () {
        Route::get('slider-page', 'SliderPage')->name('sliders');
        Route::get("/slider-list",'SliderList');
        Route::post("/create-slider",'SliderCreate');
        Route::post("/slider-by-id",'SliderByID');
        Route::post("/update-slider",'UpdateSlider');
        Route::post("/delete-slider",'DeleteSlider');
    });


    Route::controller(AboutController::class)->group(function () {
        Route::get('about-page', 'AboutPage')->name('abouts');
        Route::get("/about-list",'AboutList');
        Route::post("/create-about",'AboutCreate');
        Route::post("/about-by-id",'AboutByID');
        Route::post("/update-about",'UpdateAbout');
        Route::post("/delete-about",'DeleteAbout');
    });

    Route::controller(AdminNotificationController::class)->group(function () {
        Route::post('/markAsRead', 'MarkAsRead')->name('admin.markRead');
        Route::get('/markAsRead/notification/{notificationId}', 'MarkAsReadByType')->name('admin.MarkAsReadById');
        Route::get('/notification/{notificationId}', 'NotificationDetailsById');
        Route::get('/delete/notification/{notificationId}', 'deleteNotification');
    });

    Route::controller(AdminReportController::class)->group(function () {
        Route::get('/todays/order/reports', 'TodaysReportPage')->name('todays.report');
        Route::get('/todays/order/information', 'TodaysOrderInfo');

        Route::get('search/reports', 'ReportSearchPage')->name('search.report');
        Route::post('order/by/search', 'OrderBySearch');
    });

});



// Client API Routes
Route::prefix('client')->group(function () {
    Route::controller(ClientAuthController::class)->group(function () {
        Route::get('/registration','RegistrationPage')->name('client.registration.page');
        Route::post('/registration','Registration');

        Route::get('/login','LoginPage')->name('client.login.page');
        Route::post('/login','Login');

        Route::get('/sendOtp','SendOtpPage');
        Route::post('/send-otp','SendOTPCode');

        Route::get('/verifyOtp','VerifyOTPPage');
        Route::post('/verify-otp','VerifyOTP');

        Route::get('/resetPassword','ResetPasswordPage');
        Route::post('/reset-password','ResetPassword');
    });
});

Route::prefix('client')->middleware([ClientTokenVerificationMiddleware::class])->group(function () {
    Route::controller(ClientDashboardController::class)->group(function () {
        Route::get('/dashboard','DashboardPage')->name('client.dashboard');
        Route::get('/logout','Logout')->name('client.logout');
    });

    Route::controller(ClientProfileController::class)->group(function () {
        Route::get('/update/profile','ProfilePage');
        Route::get('/profile/info','Profile');
        Route::post('/profile/update','UpdateProfile');
        Route::get('/update/password','PasswordPage');
        Route::post('/password/update','UpdatePassword');
    });

    Route::controller(ClientFoodController::class)->group(function () {
        Route::get('food-page', 'FoodPage')->name('client.foods');
        Route::get("/index",'index');
        Route::post("/create",'create');
        Route::get("/show/{id}",'show');
        Route::post("/edit",'edit');
        Route::post("/update",'update');
        Route::post("/update-multi-image",'updateMultiImg');
        Route::post("/delete",'delete');
        Route::post("/update/status",'status');
        Route::get('/terms-conditions/{type}','TermsConditionsPage');
        Route::get('/terms-conditions-by-type/{type}','TermsConditionsByType');
    });

    Route::controller(ClientOrderController::class)->group(function () {
        Route::get('order-list', 'OrderPage')->name('client.orders');
        Route::get("/orders",'OrderList');
        Route::get("/order-details/{id}",'OrderDetails');
        Route::post("/approve/food/request",'ApproveFoodRequest');
        Route::post("/delivered/food/request",'DeliveredFoodRequest');
        Route::post("/cancel/food/request",'CancelFoodRequest');
    });

    Route::controller(ClientNotificationController::class)->group(function () {
        Route::post('/markAsRead', 'MarkAsRead')->name('client.markRead');
        Route::get('/markAsRead/notification/{notificationId}', 'MarkAsReadByType')->name('client.MarkAsReadById');
        Route::get('/notification/{notificationId}', 'NotificationDetailsById');
        Route::get('/delete/notification/{notificationId}', 'deleteNotification');
    });

    Route::controller(ClientReportController::class)->group(function () {
        Route::get('/todays/order/reports', 'TodaysReportPage')->name('client.todays.report');
        Route::get('/todays/order/information', 'TodaysOrderInfo');

        Route::get('/search/reports', 'ReportSearchPage')->name('client.search.report');
        Route::post('/order/by/search', 'OrderBySearch');
    });

});


