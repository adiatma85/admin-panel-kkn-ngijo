<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Bill
    Route::apiResource('bills', 'BillApiController');

    // Monthly Bill
    Route::apiResource('monthly-bills', 'MonthlyBillApiController');

    // User To Monthly Bill
    Route::apiResource('user-to-monthly-bills', 'UserToMonthlyBillApiController');

    // Monthly Bill To Bill
    Route::apiResource('monthly-bill-to-bills', 'MonthlyBillToBillApiController');

    // Announcement
    Route::post('announcements/media', 'AnnouncementApiController@storeMedia')->name('announcements.storeMedia');
    Route::apiResource('announcements', 'AnnouncementApiController');
});
