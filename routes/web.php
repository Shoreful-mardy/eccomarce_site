<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\RoleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[IndexController::class, 'Index']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',[UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store',[UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout',[UserController::class, 'UserDestroy'])->name('user.logout');
    Route::post('/user/change/password',[UserController::class, 'UserChangePassword'])->name('user.change.password');

    
});///Group Middleware Route End


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Dashboard Route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/admin/logout',[AdminController::class, 'AdminDestroy'])->name('admin.logout');

    Route::get('/admin/profile',[AdminController::class, 'AdminProfile'])->name('admin.profile');
    
    Route::post('/admin/profile/store',[AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password',[AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

    Route::post('/admin/update/password',[AdminController::class, 'AdminUpdatePassword'])->name('update.password');
});

//============================= Vendor All protected   Route Start ============================================
Route::middleware(['auth', 'role:vendor'])->group(function () {

    Route::get('/vendor/dashboard',[VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');

    Route::get('/vendor/logout',[VendorController::class, 'VendorDestroy'])->name('vendor.logout');

    Route::get('/vendor/profile',[VendorController::class, 'VendorProfile'])->name('vendor.profile');

    Route::post('/vendor/profile/store',[VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');

    Route::get('/vendor/change/password',[VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');

    Route::post('/vendor/update/password',[VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');

    //Vendor Add Product all route
    Route::controller(VendorProductController::class)->group(function(){
        
        Route::get('/vendor/all/product' , 'VendorAllProduct')->name('vendor.all.product');
        Route::get('/vendor/add/product' , 'VendorAddProduct')->name('vendor.add.product');
        Route::post('/vendor/store/product' , 'VendorStoreProduct')->name('vendor.store.product');
        Route::get('/vendor/edit/product/{id}' , 'VendorEditProduct')->name('vendor.edit.product');
        Route::post('/vendor/update/product' , 'VendorUpdateProduct')->name('vendor.update.product');
        Route::post('/vendor/update/product/thambnail' , 'VendorUpdateProductThambnail')->name('vendor.update.product.thambnail');
        Route::post('/vendor/update/product/multiimage' , 'VendorUpdateProductMultiImage')->name('vendor.update.product.multiimag');
        Route::get('/vendor/delete/product/multiimage/{id}' , 'VendorDeleteProductMultiImage')->name('vendor.product.multiimg.delete');
        Route::get('/vendor/product/inactive/{id}' , 'VendorProductInactive')->name('vendor.product.inactive');
        Route::get('/vendor/product/active/{id}' , 'VendorProductActive')->name('vendor.product.active');
        Route::get('/vendor/delete/product/{id}' , 'VendorDeleteProduct')->name('vendor.delete.product');


        Route::get('/vendor/subcategory/ajax/{category_id}' , 'VendorGetSubCategory');
   });

////Vendor order
   Route::controller(VendorOrderController::class)->group(function(){
       Route::get('/vendor/order' , 'VendorOrder')->name('vendor.order');
       Route::get('/vendor/return/order/' , 'VendorReturnOrder')->name('vendor.return.order');
       Route::get('/vendor/approved/return/order/' , 'VendorApprovedReturnOrder')->name('vendor.approved.return.order');
       Route::get('/vendor/order/details/{order_id}' , 'VendorOrderDetails')->name('vendor.order.details');
   });



   //Admin review all route Start
   Route::controller(ReviewController::class)->group(function(){

        Route::get('/vendor/review/' , 'VendorReview')->name('vendor.all.review');
        
    });
    //Admin review all route End

    

});// ============================= Vendor All protected   Route End ============================================


Route::get('/admin/login',[AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);

Route::get('/vendor/login',[VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/become/vendor',[VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register',[VendorController::class, 'VendorRegister'])->name('vendor.register');


//======================================Start admin Middleware======================================

Route::middleware(['auth', 'role:admin'])->group(function () {
    //Brand all route======================================
    Route::controller(BrandController::class)->group(function(){
        
         Route::get('/all/brand' , 'AllBrand')->name('all.brand');
         Route::get('/add/brand' , 'AddBrand')->name('add.brand');
         Route::post('/store/brand' , 'StoreBrand')->name('store.brand');
         Route::get('/Edit/brand/{id}' , 'EditBrand')->name('edit.brand');
         Route::post('/update/brand' , 'UpdateBrand')->name('update.brand');
         Route::get('/delete/brand/{id}' , 'DeleteBrand')->name('delete.brand');
    });

    //Category all route======================================
    Route::controller(CategoryController::class)->group(function(){
        
        Route::get('/all/category' , 'AllCategory')->name('all.category');
        Route::get('/add/category' , 'AddCategory')->name('add.category');
        Route::post('/store/category' , 'StoreCategory')->name('store.category');
        Route::get('/Edit/category/{id}' , 'EditCategory')->name('edit.category');
        Route::post('/update/category' , 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}' , 'DeleteCategory')->name('delete.category');


   });

   //Sub Category all route======================================
   Route::controller(SubCategoryController::class)->group(function(){
        
        Route::get('/all/subcategory' , 'AllSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory' , 'AddSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory' , 'StoreSubCategory')->name('store.subcategory');
        Route::get('/Edit/subcategory/{id}' , 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory' , 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}' , 'DeleteSubCategory')->name('delete.subcategory');
        
        Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');


    });

   //Vendor Active and Inactive all route=========
   Route::controller(AdminController::class)->group(function(){
        
        Route::get('/inactive/vendor' , 'InactiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor' , 'ActiveVendor')->name('active.vendor');
        Route::get('/all/vendor' , 'AllVendor')->name('all.vendor');
        Route::get('/inactive/vendor/details/{id}' , 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::post('/active/vendor/approve' , 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('/active/vendor/details/{id}' , 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/inactive/vendor/approve' , 'InactiveVendorApprove')->name('inactive.vendor.approve');
   });
   //Vendor Active and Inactive all route======================================


   //Product all route======================================
   Route::controller(ProductController::class)->group(function(){
        Route::get('/all/product' , 'AllProduct')->name('all.product');
        Route::get('/add/product' , 'AddProduct')->name('add.product');
        Route::post('/store/product' , 'StoreProduct')->name('store.product');
        Route::get('/edt/product/{id}' , 'EditProduct')->name('edit.product');
        Route::post('/update/product' , 'UpdateProduct')->name('update.product');
        Route::post('/update/product/thambnail' , 'UpdateProductThambnail')->name('update.product.thambnail');
        Route::post('/update/product/multiimage' , 'UpdateProductMultiImage')->name('update.product.multiimag');
        Route::get('/update/product/multiimage/{id}' , 'DeleteProductMultiImage')->name('product.multiimg.delete');
        Route::get('/product/inactive/{id}' , 'ProductInactive')->name('product.inactive');
        Route::get('/product/active/{id}' , 'ProductActive')->name('product.active');
        Route::get('/delete/product/{id}' , 'DeleteProduct')->name('delete.product');



        /// Product Stock
        Route::get('/product/stock/' , 'ProductStock')->name('product.stock');

   });


   
   //Slider all route Start======================================
   Route::controller(SliderController::class)->group(function(){
        Route::get('/all/slider' , 'AllSlider')->name('all.slider');
        Route::get('/add/slider' , 'AddSlider')->name('add.slider');
        Route::post('/store/slider' , 'StoreSlider')->name('store.slider');
        Route::get('/Edit/slider/{id}' , 'EditSlider')->name('edit.slider');
        Route::post('/update/slider' , 'UpdateSlider')->name('update.slider');
        Route::get('/delete/slider/{id}' , 'DeleteSlider')->name('delete.slider');
    });
    //Slider all route End======================================

    //Banner all route Start======================================
    Route::controller(BannerController::class)->group(function(){
        Route::get('/all/banner' , 'AllBanner')->name('all.banner');
        Route::get('/add/banner' , 'AddBanner')->name('add.banner');
        Route::post('/store/banner' , 'StoreBanner')->name('store.banner');
        Route::get('/Edit/banner/{id}' , 'EditBanner')->name('edit.banner');
        Route::post('/update/banner' , 'UpdateBanner')->name('update.banner');
        Route::get('/delete/banner/{id}' , 'DeleteBanner')->name('delete.banner');
    });

    //Coupon all route Start======================================
    Route::controller(CouponController::class)->group(function(){
        Route::get('/all/coupon' , 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon' , 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon' , 'StoreCoupon')->name('store.coupon');
        Route::get('/Edit/coupon/{id}' , 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon' , 'UpdateCoupon')->name('update.coupon');
        Route::get('/delete/coupon/{id}' , 'DeleteCoupon')->name('delete.coupon');
    });

    //Shipping all route Start
   Route::controller(ShippingAreaController::class)->group(function(){
        //===================Shipping Division All Route  start===================
        Route::get('/all/division' , 'AllDivision')->name('all.division');
        Route::get('/add/division' , 'AddDivision')->name('add.division');
        Route::post('/store/division' , 'StoreDivision')->name('store.division');
        Route::get('/Edit/division/{id}' , 'EditDivision')->name('edit.division');
        Route::post('/update/division' , 'UpdateDivision')->name('update.division');
        Route::get('/delete/division/{id}' , 'DeleteDivision')->name('delete.division');

        //Shipping District all route start======================================

        Route::get('/all/district' , 'AllDistrict')->name('all.district');
        Route::get('/add/district' , 'AddDistrict')->name('add.district');
        Route::post('/store/district' , 'StoreDistrict')->name('store.district');
        Route::get('/Edit/district/{id}' , 'EditDistrict')->name('edit.district');
        Route::post('/update/district' , 'UpdateDistrict')->name('update.district');
        Route::get('/delete/district/{id}' , 'DeleteDistrict')->name('delete.district');

        // Shipping State all route start ======================================

        Route::get('/all/state' , 'AllState')->name('all.state');
        Route::get('/add/state' , 'AddState')->name('add.state');
        Route::post('/store/state' , 'StoreState')->name('store.state');
        Route::get('/Edit/state/{id}' , 'EditState')->name('edit.state');
        Route::post('/update/state' , 'UpdateState')->name('update.state');
        Route::get('/delete/state/{id}' , 'DeleteState')->name('delete.state');
        Route::get('/district/ajax/{division_id}' , 'GetDistrict');
    });

   //Admin Order all route Start======================================
   Route::controller(OrderController::class)->group(function(){
        Route::get('/pending/order' , 'PendingOrder')->name('pending.order');
        Route::get('/admin/order/details/{order_id}' , 'AdminOrderDetails')->name('admin.order.details');
         Route::get('/confirm/order' , 'AdminConfirmOrder')->name('confirm.order');
         Route::get('/admin/processing/order' , 'AdminProcessingOrder')->name('admin.processing.order');
         Route::get('/admin/delivered/order' , 'AdminDeliveredOrder')->name('admin.delivered.order');
         Route::get('/admin/delivered/order' , 'AdminDeliveredOrder')->name('admin.delivered.order');

         Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
         Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcessing')->name('confirm-processing');
         Route::get('/processing/delivered/{order_id}' , 'ProcessingToDelivered')->name('processing-delivered');

          Route::get('admin/invoice/download/{order_id}' , 'AdminInvoiceDownload')->name('admin.invoice.download');
    });
    //Admin Order all route End

   //return Order all route Start
   Route::controller(ReturnController::class)->group(function(){

        Route::get('/return/request/' , 'ReturnRequest')->name('return.request');
        Route::get('/return/request/approve/{order_id}' , 'ReturnRequestApprove')->name('return.request.approve');
        Route::get('/approved/request/' , 'ApprovedRequest')->name('approved.request');

    });
    //return Order all route End

   //report all route Start
   Route::controller(ReportController::class)->group(function(){

        Route::get('/report/view/' , 'ReportView')->name('report.view');
        Route::post('/search/date/' , 'SearchByDate')->name('search-by-date');
        Route::post('/search/month/' , 'SearchByMonth')->name('search-by-months');
        Route::post('/search/year/' , 'SearchByYear')->name('search-by-year');
        Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
        Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');
    });
    //report all route End

   //Active user all route Start
   Route::controller(ActiveUserController::class)->group(function(){

        Route::get('/all/user/' , 'AllUser')->name('all-user');
        Route::get('/all/vendor/' , 'AllVendor')->name('all-vendor');
    });
    //Active user all route End


     //admin blog category  all route Start
   Route::controller(BlogController::class)->group(function(){

        Route::get('/all/blog/' , 'AllBlogCategory')->name('admin.blog.category');
        Route::get('/add/blog/category' , 'AddBlogCategory')->name('add.blog.category');
        Route::post('/store/blog/category' , 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}' , 'EditBlogCategory')->name('blog.edit.category');
        Route::post('/update/blog/category/' , 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}' , 'DeleteBlogCategory')->name('delete.blog.category');
    });
    //admin blog category all route End

    //admin blog post all route Start
   Route::controller(BlogController::class)->group(function(){

        Route::get('/all/blog/post/' , 'AllBlogPost')->name('admin.blog.post');
        Route::get('/add/blog/post' , 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post' , 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}' , 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post/' , 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}' , 'DeleteBlogPost')->name('delete.blog.post');
    });
    //admin blog post all route End


   //Admin review all route Start
   Route::controller(ReviewController::class)->group(function(){
        Route::get('/pending/review/' , 'PendingReview')->name('pending.review');
        Route::get('/approve/review/' , 'ApproveReview')->name('approve.review');
        Route::get('/admin/approve/review/{id}' , 'AdminApproveReview')->name('admin.approve.review');
        Route::get('/admin/delete/review/{id}' , 'DeleteReview')->name('review.delete');
    });
    //Admin review all route End

  //Site Setting all route Start
   Route::controller(SiteSettingController::class)->group(function(){
        Route::get('/site/setting/' , 'SiteSetting')->name('site.setting');
        Route::post('/site/setting/update/' , 'SiteSettingUpdate')->name('site.setting.update');
        Route::get('/seo/setting/' , 'SiteSettingSeo')->name('seo.setting');
        Route::post('/seo/setting/update/' , 'SeoSettingUpdate')->name('seo.setting.update');
    });
    //Site Setting all route End

    //Role & Permission all route Start
   //permission
   Route::controller(RoleController::class)->group(function(){
        Route::get('/all/permission' , 'AllPermission')->name('all.permission');
        Route::get('/add/permission' , 'AddPermission')->name('add.permission');
        Route::post('/store/permission' , 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}' , 'EditPermission')->name('edit.permission');
        Route::post('/update/permission' , 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}' , 'DeletePermission')->name('delete.permission');


        Route::get('/all/roles' , 'AllRoles')->name('all.roles');
        Route::get('/add/roles' , 'AddRoles')->name('add.roles');
        Route::post('/store/roles' , 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}' , 'EditRoles')->name('edit.roles');
        Route::post('/update/roles' , 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}' , 'DeleteRoles')->name('delete.roles');

        Route::get('/add/roles/permission' , 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store' , 'RolePermissionStore')->name('role.permission.store');

        Route::get('/all/roles/permission' , 'AllRolesPermission')->name('all.roles.permission');
        Route::get('/admin/edit/roles/{id}' , 'AdminRolesEdit')->name('admin.edit.roles');
       Route::post('/admin/roles/update/{id}' , 'AdminRolesUpdate')->name('admin.roles.update');
       Route::get('/admin/delete/roles/{id}' , 'AdminRolesDelete')->name('admin.delete.roles');
    });
    //Role & Permission all route End
    //Admin Manage route Start======================================
   Route::controller(AdminController::class)->group(function(){
        Route::get('/all/admin' , 'AllAdmin')->name('all.admin');
        Route::get('/add/admin' , 'AddAdmin')->name('add.admin');
        Route::post('/store/admin' , 'StoreAdmin')->name('store.admin');
    });
    //Admin Manage all route End======================================



     

});
//==============================End admin Middleware======================================

///Frontend Product details all route start

Route::get('/product/details/{id}/{slug}',[IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}' ,[IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all' ,[IndexController::class, 'VendorAll'])->name('vendor.all');

Route::get('product/category/{id}/{slug}',[IndexController::class, 'CatWiseProduct']);
Route::get('product/subcategory/{id}/{slug}',[IndexController::class, 'SubCatWiseProduct']);
///Frontend Product details all route end
//Product View Modal With Ajax 
Route::get('/product/view/modal/{id}',[IndexController::class, 'ProductViewAjax']);
//Add to cart data 
Route::post('/cart/data/store/{id}',[CartController::class, 'AddToCart']);
//Get Data From Cart
Route::get('/product/mini/cart',[CartController::class, 'AddMiniCart']);
//Mini Cart Remove
Route::get('/minicart/product/remove/{rowId}',[CartController::class, 'RemoveMiniCart']);
    
//Add to cart in details page 
Route::post('/dcart/data/store/{id}',[CartController::class, 'AddToCartDetails']);
//Add to wishlist 
Route::post('/add-to-wishlist/{product_id}',[WishlistController::class, 'AddToWishList']);
//Add to compare 
Route::post('/add-to-compare/{product_id}',[CompareController::class, 'AddToCompare']);






///Frontend Coupon Options 
Route::post('/coupon-apply/',[CartController::class, 'CouponApply']);
Route::get('/coupon-calculation',[CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove',[CartController::class, 'CouponRemove']);

//Checkout Page Route 
Route::get('/checkout',[CartController::class, 'CheckoutCreate'])->name('checkout');



 //cart route Start 
    Route::controller(CartController::class)->group(function(){
    Route::get('/myart' , 'MyCart')->name('mycart');
    Route::get('/get-cart-product' , 'GetCartProduct');
    Route::get('/cart-remove/{rowId}' , 'CartRemove');
    Route::get('/cart-decrement/{rowId}' , 'CartDecrement');
    Route::get('/cart-increment/{rowId}' , 'CartIncrement');
    });


    //Fontend blog post all route Start
   Route::controller(BlogController::class)->group(function(){

        Route::get('/blog/post/' , 'AllBlog')->name('home.blog');
        Route::get('/post/details/{id}/{slug}' , 'BlogDetails');
        Route::get('/catwise-post/{id}/{slug}' , 'CatBlogPost');
    });
    //Fontend blog post all route End



   //Fontend user review all route Start
   Route::controller(ReviewController::class)->group(function(){
        Route::post('/store/review/' , 'StoreReview')->name('store.review');
    });
    //Fontend user review all route End
    //Search all route Start
   Route::controller(IndexController::class)->group(function(){
        Route::post('/product/search/' , 'ProductSearch')->name('product.search');
        Route::post('/search-product' , 'SearchProduct');
    });
    //Search all route End


//======================================Start user Middleware======================================
Route::middleware(['auth', 'role:user'])->group(function () {

     //user route Start
    Route::controller(WishlistController::class)->group(function(){
    Route::get('/wishlist' , 'AllWishlist')->name('wishlist');
    Route::get('/get-wishlist-product' , 'GetWishListProduct');
    Route::get('/wishlist-remove/{id}' , 'WishListRemove');
    });

    //Compare route Start
    Route::controller(CompareController::class)->group(function(){
    Route::get('/compare' , 'AllCompare')->name('compare');
    Route::get('/get-compare-product' , 'GetCompareProduct');
    Route::get('/compare-remove/{id}' , 'CompareRemove');

    });


    //Check Out route Start
    Route::controller(CheckoutController::class)->group(function(){
    Route::get('/district-get/ajax/{division_id}' , 'DistrictGetAjax');
    Route::get('/state-get/ajax/{district_id}' , 'StateGetAjax');
    Route::post('/checkout/store' , 'CheckOutStore')->name('checkout.store');
    });

    //Stripe route Start
    Route::controller(StripeController::class)->group(function(){
        Route::post('/stripe/order' , 'StripeOrder')->name('stripe.order');
        Route::post('/cash/order' , 'CashOrder')->name('cash.order');
    });

    //User dashboard protected route Start
    Route::controller(AllUserController::class)->group(function(){
        Route::get('/user/account/page' , 'UserAccount')->name('user.account.page');
        Route::get('/change/password' , 'ChangePassword')->name('change.password');
        Route::get('/user/order' , 'UserOrderPage')->name('user.order.page');
        Route::get('/user/order_details/{order_id}' , 'UserOrderDetails');
        Route::get('/user/order_download/{order_id}' , 'UserOrderDownload');

        Route::post('/return/order/{order_id}' , 'RetunrOrder')->name('return.order');
        Route::get('/user/return/order/page' , 'RetunrOrderPage')->name('user.return.order.page');
        Route::get('/user/order/track' , 'UserTrackOrder')->name('user.track.order');
        Route::post('/order/tracking' , 'OrderTracking')->name('order.tracking');
    });
   



});
// ======================================End User Middleware======================================