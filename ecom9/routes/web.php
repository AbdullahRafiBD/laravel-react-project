<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function () {
        // Admin Dashboard Route
        Route::get('dashboard', 'AdminController@dashboard');
        // Admin Logout
        Route::get('logout', 'AdminController@logout');
        // Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword');
        // check Admin Password
        Route::post('check-current-password', 'AdminController@checkAdminPassword');
        // update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');
        // update Vendor Details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');
        // view Admins / Subadmins / Vendors
        Route::get('admins/{type?}', 'AdminController@admins');
        // View Vendor Details
        Route::get('view-vendor-details/{id}', 'AdminController@viewVendorDetails');
        // Update Admin Status
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');

        // Sections start here
        Route::get('sections', 'SectionController@sections');
        // Update Sections Status
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        //Delete Section
        Route::get('delete-section/{id}', 'SectionController@deleteSection');
        // section add edit (? meaning id astew pare naw pare )
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');

        // Categories start here
        Route::get('categories', 'CategoryController@categories');
        // Update Categories Status
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        // Category add edit (? meaning id astew pare naw pare )
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        // subCategory ajax
        Route::get('append-categories-level', 'CategoryController@appendCategoryLevel');
        //Delete Category
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');
        //Delete Category Image
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');

        // Brands start here
        Route::get('brands', 'BrandController@brands');
        // Update Brands Status
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        // Brand add edit (? meaning id astew pare naw pare )
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        //Delete Brand
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');
        //Delete Brand Image
        Route::get('delete-brand-image/{id}', 'BrandController@deleteBrandImage');

        // Products start here
        Route::get('products', 'ProductsController@products');
        // Update Products Status
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        //Delete Product
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        // Product add edit (? meaning id astew pare naw pare )
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        //Delete Product Image
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        //Delete Product Video
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        // Attributes
        Route::match(['get', 'post'], 'add-edit-attributes/{id}', 'ProductsController@addAttributes');
        // Update Attribute Status
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        //Delete Product Attrebute
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');
        // Edit Attribute
        Route::match(['get', 'post'], 'edit-attributes/{id}', 'ProductsController@editAttribute');

        // Filters
        Route::get('filters', 'FilterController@filters');
        // Filters value
        Route::get('filters-values', 'FilterController@filtersValues');
        // Update Filters Status
        Route::post('update-filter-status', 'FilterController@updateFilterStatus');
        // Update Filters Value Status
        Route::post('update-filter-value-status', 'FilterController@updateFilterValueStatus');
        // add Edit filter
        Route::match(['get', 'post'], 'add-edit-filter/{id?}', 'FilterController@addEditFilter');
        // add Edit filter Value
        Route::match(['get', 'post'], 'add-edit-filter-value/{id?}', 'FilterController@addEditFilterValue');
        // ajax filter match with category
        Route::post('category-filters', 'FilterController@categoryFilters');



        // Product Images Upload
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        // Update Image Status
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        //Delete Product Image
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');

        // Banner start here
        Route::get('banners', 'BannersController@banners');
        // Update Banners Status
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        //Delete Banner
        Route::get('delete-banner/{id}', 'BannersController@deleteBanner');
        // Banner add edit (? meaning id astew pare naw pare )
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');


        // CMS Pages
        Route::get('cms-pages', 'CmsController@cmspages');
        // Update CMS Pages Status
        Route::post('update-cms-page-status', 'CmsController@updatePageStatus');
        //Delete Page
        Route::get('delete-page/{id}', 'CmsController@deletePage');
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/', 'IndexController@index');
    // Route::match(['get', 'post'], '/', 'IndexController@index');

    // Listing Category Route
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    // dd($catUrls);die;
    foreach ($catUrls as $key => $url) {
        Route::match(['get', 'post'], '/' . $url, 'ProductsController@listing');
    }



    // Vendor Login/Register
    Route::get('vendor/login-register', 'VendorController@loginRegister');

    // Vendor Register Form Post
    Route::post('vendor/register', 'VendorController@vendorRegister');

    // Confirm Vendor Account
    Route::get('vendor/confirm/{code}', 'VendorController@vendorConfirm');


    // Product Detail Page
    Route::get('/product/{id}', 'ProductsController@detail');
    // Get Product Attribute Price
    Route::post('/get-product-price', 'ProductsController@getProductPrice');
    // Vendor shop Product Detail Page
    Route::get('/products/{vendorid}', 'ProductsController@vendorListing');


    // Add to Cart Route
    Route::post('cart/add', 'ProductsController@cartAdd');
    //cart page route
    Route::get('/cart', 'ProductsController@cart');
    // Update Cart Item Quantity Route
    Route::post('/cart/update', 'ProductsController@cartUpdate');
    // Delete Cart Item Route
    Route::post('/cart/delete', 'ProductsController@cartDelete');


    // User Login/Register
    Route::get('user/login-register', 'UserController@loginRegister');
    // User Register
    Route::post('user/register', 'UserController@userRegister');
    // User Login
    Route::post('user/login', 'UserController@userLogin');
    // User Logout
    Route::get('user/logout', 'UserController@userLogout');
    // Confirm User Account
    Route::get('user/confirm/{code}', 'UserController@confirmAccount');
});
