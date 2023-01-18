<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectLinksController;
use App\Http\Controllers\LinkSettingController;
use App\Http\Controllers\BiolinkSettingController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\BiolinkSectionController;
use App\Http\Controllers\Admin\UserManagerController;
use App\Http\Controllers\Admin\ResellerManagerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionsController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminProjectLinkController;
use App\Http\Controllers\SPAController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProjectTeamController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductCouponController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MembershipBlogController;
use App\Http\Controllers\PlanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::get('/products/{projectId}', [ProductController::class, 'index']);
    Route::get('/product/categories/{projectId}', [ProductCategoryController::class, 'index']);
    Route::get('/product/coupons/{projectId}', [ProductCouponController::class, 'index']);
    Route::group(['prefix' => 'product'], function () {
        Route::post('/store', [ProductController::class, 'store']);
        Route::post('/duplicate/{id}', [ProductController::class, 'duplicate']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/{id}', [ProductController::class, 'destroy']);

        Route::get('/category/search/{projectId}', [ProductCategoryController::class, 'search']);
        Route::get('/category/show/{id}', [ProductCategoryController::class, 'show']);
        Route::put('/category/update/{id}', [ProductCategoryController::class, 'update']);
        Route::delete('/category/delete/{id}', [ProductCategoryController::class, 'destroy']);

        Route::post('/coupon/store', [ProductCouponController::class, 'store']);
        Route::get('/coupon/show/{id}', [ProductCouponController::class, 'show']);
        Route::put('/coupon/update/{id}', [ProductCouponController::class, 'update']);
        Route::delete('/coupon/delete/{id}', [ProductCouponController::class, 'destroy']);
    });

    Route::group(['prefix' => 'membership'], function () {
        Route::get('/posts/{projectId}', [PostController::class, 'index']);
        Route::group(['prefix' => 'post'], function () {
            Route::post('/store', [PostController::class, 'store']);
            Route::post('/duplicate/{id}', [PostController::class, 'duplicate']);
            Route::get('/show/{id}', [PostController::class, 'show']);
            Route::put('/update/{id}', [PostController::class, 'update']);
            Route::delete('/delete/{id}', [PostController::class, 'destroy']);
        });

        Route::group(['prefix' => 'blog'], function () {
            Route::post('/store', [MembershipBlogController::class, 'store']);
            Route::get('/show/{projectId}', [MembershipBlogController::class, 'show']);
        });

        Route::get('/plans/{projectId}', [PlanController::class, 'index']);
        Route::group(['prefix' => 'plan'], function () {
            Route::post('/store', [PlanController::class, 'store']);
            Route::get('/show/{projectId}', [PlanController::class, 'show']);
            Route::put('/update/{id}', [PlanController::class, 'update']);
            Route::delete('/delete/{id}', [PlanController::class, 'destroy']);
        });
    });

    Route::get('/report/dashbord-cards', [ReportController::class, 'dashboardCardSummary']);
    Route::get('/report/project-links/{projectId}', [ReportController::class, 'projectLinkClicks']);
    Route::get('/report/leads/{linkId}', [ReportController::class, 'leads']);
    Route::get('/report/leads/total/{linkId}', [ReportController::class, 'totalLeads']);
    Route::get('/report/page-view/{linkId}', [ReportController::class, 'pageView']);
    Route::post('/report/export-leads', [ReportController::class, 'exportLeads']);

    Route::put('/account/update', [ProfileController::class, 'updateAccount']);
    Route::put('/password/update', [ProfileController::class, 'updatePassword']);
    Route::get('/user-logs/{email}', [ProfileController::class, 'loginHistory']);
    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::group(['prefix' => 'project'], function () {
        Route::post('/store', [ProjectController::class, 'store']);
        Route::get('/show/{projectId}', [ProjectController::class, 'show']);
        Route::put('/update/{projectId}', [ProjectController::class, 'update']);
        Route::delete('/delete/{projectId}', [ProjectController::class, 'delete']);
        Route::post('/invitation', [ProjectInvitationController::class, 'sendInvitation']);
        Route::get('/{projectId}/team', [ProjectTeamController::class, 'projectMembers']);
        Route::delete('/{projectId}/member', [ProjectTeamController::class, 'removeMember']);
    });

    Route::get('/links', [ProjectLinksController::class, 'index']);
    Route::group(['prefix' => 'link'], function () {
        Route::post('/store', [ProjectLinksController::class, 'store']);
        Route::get('/show/{linkId}', [ProjectLinksController::class, 'show']);
        Route::get('/edit/{id}', [ProjectLinksController::class, 'edit']);
        Route::put('/update/status/{id}', [ProjectLinksController::class, 'updateStatus']);
        Route::put('/update/link/{id}', [ProjectLinksController::class, 'updateLink']);
        Route::put('/update/biolink/{id}', [ProjectLinksController::class, 'updateBiolink']);
        Route::post('/duplicate/{id}', [ProjectLinksController::class, 'duplicate']);
        Route::delete('/delete/{id}', [ProjectLinksController::class, 'delete']);

        Route::get('/link/{id}', [LinkSettingController::class, 'index']);

        Route::group(['prefix' => 'biolink'], function () {
            Route::get('/settings/{id}', [BiolinkSettingController::class, 'index']);
            Route::put('/settings/{id}', [BiolinkSettingController::class, 'updateSettings']);
            Route::get('/custom/{id}', [BiolinkSettingController::class, 'getCustomSettings']);
            Route::put('/custom/{id}', [BiolinkSettingController::class, 'updateCustomSettings']);

            Route::get('/sections/{linkid}', [BiolinkSectionController::class, 'index']);
            Route::post('/section', [BiolinkSectionController::class, 'store']);
            Route::put('/section/{id}', [BiolinkSectionController::class, 'update']);
            Route::get('/section/{id}', [BiolinkSectionController::class, 'show']);
            Route::delete('/section/{id}', [BiolinkSectionController::class, 'delete']);
            Route::put('/section/status/{id}', [BiolinkSectionController::class, 'updateStatus']);
            Route::post('/section/position', [BiolinkSectionController::class, 'updateSectionPosition']);
        });
    });

    Route::get('/roles', [RoleController::class, 'index']);
    Route::group(['prefix' => 'role'], function () {
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'delete']);
    });

    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::group(['prefix' => 'permission'], function () {
        Route::post('/', [PermissionController::class, 'store']);
        Route::put('/{id}', [PermissionController::class, 'update']);
        Route::delete('/{id}', [PermissionController::class, 'delete']);
    });

    Route::get('/role-permission/{roleId}', [RolePermissionsController::class, 'rolePermissions']);
    Route::post('/assign-permissions', [RolePermissionsController::class, 'assignPermissionsToRole']);

    Route::get('/users', [UserManagerController::class, 'index']);
    Route::group(['prefix' => 'user'], function () {
        Route::post('/', [UserManagerController::class, 'store']);
        Route::put('/{id}', [UserManagerController::class, 'update']);
        Route::put('/block/{id}', [UserManagerController::class, 'block']);
        Route::delete('/{id}', [UserManagerController::class, 'delete']);
    });

    Route::group(['prefix' => 'reseller'], function () {
        Route::get('/users', [ResellerManagerController::class, 'index']);
        Route::get('/roles', [ResellerManagerController::class, 'resellerRole']);
        Route::group(['prefix' => 'user'], function () {
            Route::post('/', [ResellerManagerController::class, 'store']);
            Route::put('/{id}', [ResellerManagerController::class, 'update']);
            Route::put('/block/{id}', [ResellerManagerController::class, 'block']);
            Route::delete('/{id}', [ResellerManagerController::class, 'delete']);
        });
    });

    Route::get('/admin/projects', [AdminProjectController::class, 'index']);
    Route::get('/admin/project-links', [AdminProjectLinkController::class, 'index']);
    Route::get('/admin/login-history', [LogsController::class, 'getLoginHistory']);
    Route::get('/countries', [HelperController::class, 'country']);
    Route::get('/languages', [HelperController::class, 'language']);
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::get('/project/invitation/{id}', [ProjectInvitationController::class, 'getInvitationInfo']);
Route::post('/register/{id}', [RegisterController::class, 'registerMember']);
Route::post('/mail-signup', [SPAController::class, 'mailSignup']);
Route::post('/leadgen', [SPAController::class, 'leadgen']);
Route::post('/visits', [SPAController::class, 'storeVisits']);