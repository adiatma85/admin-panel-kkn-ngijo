<?php

// Add on to not show the error in web/routes/php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Bill
    Route::delete('bills/destroy', 'BillController@massDestroy')->name('bills.massDestroy');
    Route::resource('bills', 'BillController');

    // Monthly Bill
    Route::delete('monthly-bills/destroy', 'MonthlyBillController@massDestroy')->name('monthly-bills.massDestroy');
    Route::resource('monthly-bills', 'MonthlyBillController');

    // User To Monthly Bill
    Route::delete('user-to-monthly-bills/destroy', 'UserToMonthlyBillController@massDestroy')->name('user-to-monthly-bills.massDestroy');
    Route::resource('user-to-monthly-bills', 'UserToMonthlyBillController');

    // Monthly Bill To Bill
    Route::delete('monthly-bill-to-bills/destroy', 'MonthlyBillToBillController@massDestroy')->name('monthly-bill-to-bills.massDestroy');
    Route::resource('monthly-bill-to-bills', 'MonthlyBillToBillController');

    // Announcement
    Route::delete('announcements/destroy', 'AnnouncementController@massDestroy')->name('announcements.massDestroy');
    Route::post('announcements/media', 'AnnouncementController@storeMedia')->name('announcements.storeMedia');
    Route::post('announcements/ckmedia', 'AnnouncementController@storeCKEditorImages')->name('announcements.storeCKEditorImages');
    Route::resource('announcements', 'AnnouncementController');

    // Scope
    Route::delete('scopes/destroy', 'ScopeController@massDestroy')->name('scopes.massDestroy');
    Route::resource('scopes', 'ScopeController');

    // Pembayaran
    Route::post('pembayarans/media', 'UserPembayaranController@storeMedia')->name('pembayarans.storeMedia');
    Route::resource('pembayarans', 'UserPembayaranController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
