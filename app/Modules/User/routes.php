<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// ******************* Admin Routes ********************* { //
/*
 *
 * Administrator panel routes
 *
 */

Route::prefix(config('setting.admin_url'))->group( function()
{
    // Get no access pages
    Route::get('noaccess', 'App\Modules\BaseAdmin@unauthorize')->name('admin.noaccess');
    Route::get('noaccess', 'App\Modules\BaseAdmin@index')->name('admin.noaccess');

    // ******************* Shortcut for Developer Setup ******************** //

    // Get main administrator login
    Route::get('setup/first/migrate', 'App\Modules\BaseAdmin@setup')->name('first.migrate');
    Route::post('setup/first/migrate', 'App\Modules\BaseAdmin@setup')->name('first.migrate.post');

    // ******************* Admin\AuthAdminController ********************* { //

    // Get main administrator login
    Route::get('/', 'App\Modules\Admin\AuthAdminController@index');

    // ByPass to admin auth controller in middleware | Login
    Route::get('login', 'App\Modules\Admin\AuthAdminController@login')->name('admin.login');
    Route::post('login', 'App\Modules\Admin\AuthAdminController@processLogin')->name('admin.login');

    // ByPass to admin auth controller in middleware | Logout
    Route::get('logout', 'App\Modules\Admin\AuthAdminController@logout')->name('admin.logout');

    // ByPass to admin auth controller in middleware | Register
    Route::get('register', 'App\Modules\Admin\AuthAdminController@register');
    Route::post('register', 'App\Modules\Admin\AuthAdminController@processRegistration');

    // Get users team invitation process
    Route::get('invitation/{id}/{action}', 'App\Modules\Admin\AuthAdminController@invitation')->name('admin.invitation');

    //Route::get('invitation', ['as'=>'admin.invitation','uses'=>'App\Modules\Admin\AuthAdminController@invitation']);

    // } ****************** Admin\AuthAdminController ****************** //

    // Users Controller
    Route::get('account', 'App\Modules\User\Controller\Users@profile')->name('admin.account');
    // Get admin panel controllers routes
    Route::get('profile', 'App\Modules\User\Controller\Users@profile')->name('admin.profile');

    // Get admin panel controllers routes
    Route::get('dashboard', 'App\Modules\User\Controller\Users@dashboard')->name('admin.dashboard');

    Route::get('user', ['as'=>'admin.users.index','uses'=>'App\Modules\User\Controller\Users@index']);
    Route::get('user/export', ['as'=>'admin.users.export','uses'=>'App\Modules\User\Controller\Users@export']);
    Route::get('user/create', ['as'=>'admin.users.create', 'uses'=>'App\Modules\User\Controller\Users@create']);
    Route::post('user/create', ['as'=>'admin.users.store', 'uses'=>'App\Modules\User\Controller\Users@store']);
    Route::get('user/{id}/show', ['as'=>'admin.users.show', 'uses'=>'App\Modules\User\Controller\Users@show']);
    Route::get('user/{id}', ['as'=>'admin.users.edit', 'uses'=>'App\Modules\User\Controller\Users@edit']);
    Route::post('user/{id}', ['as'=>'admin.users.update', 'uses'=>'App\Modules\User\Controller\Users@update']);
    Route::get('user/{id}/trash', ['as'=>'admin.users.trash','uses'=>'App\Modules\User\Controller\Users@trash']);
    Route::get('user/{id}/restored', ['as'=>'admin.users.restored','uses'=>'App\Modules\User\Controller\Users@restored']);
    Route::get('user/{id}/delete', ['as'=>'admin.users.delete','uses'=>'App\Modules\User\Controller\Users@delete']);
    Route::get('user/crop/{id}', ['as'=>'admin.users.crop','uses'=>'App\Modules\User\Controller\Users@crop']);

    // Roles Controller routes
    Route::get('role', ['as'=>'admin.roles.index','uses'=>'App\Modules\User\Controller\Roles@index']);
    Route::get('role/create', ['as'=>'admin.roles.create','uses'=>'App\Modules\User\Controller\Roles@create']);
    Route::post('role/create', ['as'=>'admin.roles.store','uses'=>'App\Modules\User\Controller\Roles@store']);
    Route::get('role/{id}/show', ['as'=>'admin.roles.show', 'uses'=>'App\Modules\User\Controller\Roles@show']);
    Route::get('role/{id}', ['as'=>'admin.roles.edit','uses'=>'App\Modules\User\Controller\Roles@edit']);
    Route::post('role/{id}', ['as'=>'admin.roles.update','uses'=>'App\Modules\User\Controller\Roles@update']);
    Route::get('role/{id}/trash', ['as'=>'admin.roles.trash','uses'=>'App\Modules\User\Controller\Roles@trash']);
    Route::get('role/{id}/restored', ['as'=>'admin.roles.restored','uses'=>'App\Modules\User\Controller\Roles@restored']);
    Route::get('role/{id}/delete', ['as'=>'admin.roles.delete','uses'=>'App\Modules\User\Controller\Roles@delete']);

    // Teams Controller routes
    Route::get('team', ['as'=>'admin.teams.index','uses'=>'App\Modules\User\Controller\Teams@index']);
    // Send invitation to the team
    Route::get('team/invitation', ['as'=>'admin.teams.invitation','uses'=>'App\Modules\User\Controller\Teams@invitation']);
    Route::post('team/invite', ['as'=>'admin.teams.invite','uses'=>'App\Modules\User\Controller\Teams@invite']);
    Route::get('team/create', ['as'=>'admin.teams.create','uses'=>'App\Modules\User\Controller\Teams@create']);
    Route::post('team/create', ['as'=>'admin.teams.store','uses'=>'App\Modules\User\Controller\Teams@store']);
    Route::get('team/{id}/show', ['as'=>'admin.teams.show', 'uses'=>'App\Modules\User\Controller\Teams@show']);
    Route::get('team/{id}', ['as'=>'admin.teams.edit','uses'=>'App\Modules\User\Controller\Teams@edit']);
    Route::post('team/{id}', ['as'=>'admin.teams.update','uses'=>'App\Modules\User\Controller\Teams@update']);
    Route::get('team/{id}/trash', ['as'=>'admin.teams.trash','uses'=>'App\Modules\User\Controller\Teams@trash']);
    Route::get('team/{id}/restored', ['as'=>'admin.teams.restored','uses'=>'App\Modules\User\Controller\Teams@restored']);
    Route::get('team/{id}/delete', ['as'=>'admin.teams.delete','uses'=>'App\Modules\User\Controller\Teams@delete']);

     // Permissions Controller routes
    Route::get('permission', ['as'=>'admin.permissions.index','uses'=>'App\Modules\User\Controller\Permissions@index']);
    Route::get('permission/create', ['as'=>'admin.permissions.create','uses'=>'App\Modules\User\Controller\Permissions@create']);
    Route::post('permission/create', ['as'=>'admin.permissions.store','uses'=>'App\Modules\User\Controller\Permissions@store']);
    Route::get('permission/{id}', ['as'=>'admin.permissions.edit','uses'=>'App\Modules\User\Controller\Permissions@edit']);
    Route::post('permission/{id}', ['as'=>'admin.permissions.update','uses'=>'App\Modules\User\Controller\Permissions@update']);
    Route::get('permission/{id}/delete', ['as'=>'admin.permissions.delete','uses'=>'App\Modules\User\Controller\Permissions@delete']);
    // Ajax Controller
    Route::post('permission/{id}/change', ['as'=>'admin.permissions.change','uses'=>'App\Modules\User\Controller\Permissions@change']);

    Route::get('log', 'App\Modules\User\Controller\Logs@index')->name('admin.logs.index');
    Route::get('log/export', 'App\Modules\User\Controller\Logs@export')->name('admin.logs.export');
    Route::get('log/{id}/show', 'App\Modules\User\Controller\Logs@show')->name('admin.logs.show');
    Route::get('log/{id}/trash', 'App\Modules\User\Controller\Logs@trash')->name('admin.logs.trash');
    Route::get('log/{id}/delete', 'App\Modules\User\Controller\Logs@delete')->name('admin.logs.delete');
    
    // Settings Controller routes
    Route::get('setting', ['as'=>'admin.settings.index','uses'=>'App\Modules\User\Controller\Settings@index']);
    // Ajax Controller
    Route::post('setting/change', 'App\Modules\User\Controller\Settings@change')->name('admin.settings.change');
    Route::get('setting/create', ['as'=>'admin.settings.create','uses'=>'App\Modules\User\Controller\Settings@create']);
    Route::post('setting/create', ['as'=>'admin.settings.store','uses'=>'App\Modules\User\Controller\Settings@store']);
    Route::get('setting/{id}/show', ['as'=>'admin.settings.show', 'uses'=>'App\Modules\User\Controller\Settings@show']);
    Route::get('setting/{id}', ['as'=>'admin.settings.edit','uses'=>'App\Modules\User\Controller\Settings@edit']);
    Route::post('setting/{id}', ['as'=>'admin.settings.update','uses'=>'App\Modules\User\Controller\Settings@update']);
    Route::get('setting/{id}/trash', ['as'=>'admin.settings.trash','uses'=>'App\Modules\User\Controller\Settings@trash']);
    Route::get('setting/{id}/restored', ['as'=>'admin.settings.restored','uses'=>'App\Modules\User\Controller\Settings@restored']);
    Route::get('setting/{id}/delete', ['as'=>'admin.settings.delete','uses'=>'App\Modules\User\Controller\Settings@delete']);


});
