<?php

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/admin/login', 'Admin\AuthController@login');
    Route::post('/admin/CheckLogin', 'Admin\AuthController@CheckLogin');
    Route::get('/admin/debug', function(){
        return view('debug');
    });


    Route::group(['middleware' => 'admin_auth','prefix' => 'admin'], function(){
        Route::get('/testQrcodeByNomklong',function(){
            $result = \App\Models\Activities::first();
            $data['png'] = \QrCode::format('png')->encoding('UTF-8')->size(250)->generate(url("/QRCODE/".$result->code));

            $data['main_menu'] = 'ตั้งค่า';
            $data['sub_menu'] = 'พนักงาน';
            $data['title_page'] = 'พนักงาน';
            $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
            return View::make('test',$data);
        });
        Route::get('/', 'Admin\HomeController@index');
        Route::get('/logout', 'Admin\AuthController@logout');
        Route::get('/dashboard', 'Admin\HomeController@index');
        Route::post('/upload_file', 'Admin\UploadFileController@index');

        //User
        Route::get('/change_password', 'Admin\UserController@change_password');
        Route::get('/profile', 'Admin\UserController@profile');
        Route::get('/user/ListUser', 'Admin\UserController@ListUser');
        Route::post('/user/change_password', 'Admin\UserController@change_password');
        Route::post('/user/checkedit/{id}', 'Admin\UserController@update');
        Route::post('/user/delete/{id}', 'Admin\UserController@destroy');
        Route::resource('/user', 'Admin\UserController');
        // Route::get('/user', 'Admin\UserController@index');
        Route::get('/logout', 'Admin\AuthController@logout');

        //ManageMenu
        Route::get('/ManageMenu', 'Admin\MenuController@index');
        Route::get('/menu/ListMenu', 'Admin\MenuController@ListMenu');
        Route::post('/menu', 'Admin\MenuController@store');
        Route::get('/menu/{id}', 'Admin\MenuController@edit');
        Route::post('/menu/checkedit/{id}', 'Admin\MenuController@update');
        Route::post('/menu/delete/{id}', 'Admin\MenuController@destroy');

        //SetPermission
        Route::post('/SetPermission', 'Admin\MenuController@SetPermission');
        Route::post('/GetPermission/{id}', 'Admin\MenuController@GetPermission');

        Route::get('/Install', 'Admin\InstallController@index');
        Route::get('/Install/DefaultView', 'Admin\InstallController@DefaultView');
        Route::post('/Install/GetFieldDropDown', 'Admin\InstallController@GetFieldDropDown');
        Route::post('/Install/GetField/{table}', 'Admin\InstallController@GetField');
        Route::post('/Install', 'Admin\InstallController@Install');

        Route::get('/Menu', 'Admin\MenuController@index');
        Route::get('/Menu/Lists', 'Admin\MenuController@Lists');
        Route::post('/Menu', 'Admin\MenuController@store');
        Route::get('/Menu/{id}', 'Admin\MenuController@show');
        Route::post('/Menu/{id}', 'Admin\MenuController@update');
        Route::post('/Menu/Delete/{id}', 'Admin\MenuController@destroy');

    Route::get('/AdminUser', 'Admin\AdminUserController@index');
        Route::get('/AdminUser/Lists', 'Admin\AdminUserController@Lists');
        Route::post('/AdminUser', 'Admin\AdminUserController@store');
        Route::get('/AdminUser/{id}', 'Admin\AdminUserController@show');
        Route::post('/AdminUser/{id}', 'Admin\AdminUserController@update');
        Route::post('/AdminUser/Delete/{id}', 'Admin\AdminUserController@destroy');

      Route::get('/Test', 'Admin\TestController@index');
        Route::get('/Test/Lists', 'Admin\TestController@Lists');
        Route::post('/Test', 'Admin\TestController@store');
        Route::get('/Test/{id}', 'Admin\TestController@show');
        Route::post('/Test/{id}', 'Admin\TestController@update');
        Route::post('/Test/Delete/{id}', 'Admin\TestController@destroy');

      Route::get('/Test', 'Admin\TestController@index');
        Route::get('/Test/Lists', 'Admin\TestController@Lists');
        Route::post('/Test', 'Admin\TestController@store');
        Route::get('/Test/{id}', 'Admin\TestController@show');
        Route::post('/Test/{id}', 'Admin\TestController@update');
        Route::post('/Test/Delete/{id}', 'Admin\TestController@destroy');

      Route::get('/Test', 'Admin\TestController@index');
        Route::get('/Test/Lists', 'Admin\TestController@Lists');
        Route::post('/Test', 'Admin\TestController@store');
        Route::get('/Test/{id}', 'Admin\TestController@show');
        Route::post('/Test/{id}', 'Admin\TestController@update');
        Route::post('/Test/Delete/{id}', 'Admin\TestController@destroy');

      Route::get('/Employee', 'Admin\EmployeeController@index');
        Route::get('/Employee/Lists', 'Admin\EmployeeController@Lists');
        Route::post('/Employee', 'Admin\EmployeeController@store');
        Route::get('/Employee/{id}', 'Admin\EmployeeController@show');
        Route::post('/Employee/{id}', 'Admin\EmployeeController@update');
        Route::post('/Employee/Delete/{id}', 'Admin\EmployeeController@destroy');

      Route::get('/UserDepartment', 'Admin\UserDepartmentController@index');
        Route::get('/UserDepartment/Lists', 'Admin\UserDepartmentController@Lists');
        Route::post('/UserDepartment', 'Admin\UserDepartmentController@store');
        Route::get('/UserDepartment/{id}', 'Admin\UserDepartmentController@show');
        Route::post('/UserDepartment/{id}', 'Admin\UserDepartmentController@update');
        Route::post('/UserDepartment/Delete/{id}', 'Admin\UserDepartmentController@destroy');

      Route::get('/Guest', 'Admin\GuestController@index');
        Route::get('/Guest/Lists', 'Admin\GuestController@Lists');
        Route::post('/Guest', 'Admin\GuestController@store');
        Route::get('/Guest/{id}', 'Admin\GuestController@show');
        Route::post('/Guest/{id}', 'Admin\GuestController@update');
        Route::post('/Guest/Delete/{id}', 'Admin\GuestController@destroy');

      Route::get('/Activities', 'Admin\ActivitiesController@index');
        Route::get('/Activities/Lists', 'Admin\ActivitiesController@Lists');
        // Route::get('/Activities/QRCODE', 'Admin\ActivitiesController@QRCODE');
        Route::get('/Activities/RewardLists', 'Admin\ActivitiesController@RewardLists');
        Route::post('/Activities', 'Admin\ActivitiesController@store');
        Route::get('/gen_qr_code', 'Admin\ActivitiesController@gen_qr_code');
        Route::get('/Activities/staff/{id}', 'Admin\ActivitiesController@staff');
        Route::get('/Activities/AllSpeQues/{id}', 'Admin\ActivitiesController@AllSpeQues');
        Route::post('/Activities/RewardAccept', 'Admin\ActivitiesController@RewardAccept');
        Route::get('/Activities/{id}', 'Admin\ActivitiesController@show');
        Route::get('/Activities/getStaff/{id}', 'Admin\ActivitiesController@getStaff');

        Route::get('/Activities/Detail/{id}', 'Admin\ActivitiesController@show');
        Route::get('/Activities/getReward/{id}', 'Admin\ActivitiesController@getReward');
        Route::get('/Activities/getDownloadQrcode/{id}', 'Admin\ActivitiesController@getDownloadQrcode');
        Route::get('/Activities/getActivityQuestion/{id}', 'Admin\ActivitiesController@getActivityQuestion');
        Route::get('/Activities/getSpecialQuestion/{id}', 'Admin\ActivitiesController@getSpecialQuestion');
        Route::post('/Activities/updateStatus/{id}', 'Admin\ActivitiesController@updateStatus');
        Route::post('/Activities/AddQuestion/{id}', 'Admin\ActivitiesController@AddQuestion');
        Route::post('/Activities/AddStaff/{id}', 'Admin\ActivitiesController@AddStaff');
        Route::post('/Activities/AddSpecialQuestion/{id}', 'Admin\ActivitiesController@AddSpecialQuestion');
        Route::post('/Activities/{id}', 'Admin\ActivitiesController@update');
        Route::post('/Activities/Delete/{id}', 'Admin\ActivitiesController@destroy');
        Route::post('/AnswerHistoryInit', 'Admin\ActivitiesController@storeHistoryInit');
        Route::get('/Activities/GetSpecQuestion/{id}', 'Admin\ActivitiesController@GetSpecQuestion');


      Route::get('/Answer', 'Admin\AnswerController@index');
        Route::get('/Answer/Lists', 'Admin\AnswerController@Lists');
        Route::post('/Answer', 'Admin\AnswerController@store');
        Route::get('/Answer/{id}', 'Admin\AnswerController@show');
        Route::get('/showAnswerQuestion/{id}', 'Admin\AnswerController@showAnswerQuestion');
        Route::post('/Answer/{id}', 'Admin\AnswerController@update');
        Route::post('/Answer/Delete/{id}', 'Admin\AnswerController@destroy');
        Route::post('/Answer/deleteAnswer/{id}', 'Admin\AnswerController@deleteAnswer');

      Route::get('/ActivityRewardUser', 'Admin\ActivityRewardUserController@index');
        Route::get('/ActivityRewardUser/Lists', 'Admin\ActivityRewardUserController@Lists');
        Route::post('/ActivityRewardUser', 'Admin\ActivityRewardUserController@store');
        Route::get('/ActivityRewardUser/{id}', 'Admin\ActivityRewardUserController@show');
        Route::get('/ActivityRewardUser/report/{start}/{end}', 'Admin\ActivityRewardUserController@report');
        Route::post('/ActivityRewardUser/{id}', 'Admin\ActivityRewardUserController@update');
        Route::post('/ActivityRewardUser/Delete/{id}', 'Admin\ActivityRewardUserController@destroy');

      Route::get('/QuestionInit', 'Admin\QuestionInitController@index');
        Route::get('/QuestionInit/Lists', 'Admin\QuestionInitController@Lists');
        Route::post('/QuestionInit', 'Admin\QuestionInitController@store');
        Route::post('/QuestionInit/AddAnswer', 'Admin\QuestionInitController@AddAnswer');
        Route::get('/SpecialQuestion', 'Admin\QuestionInitController@GetSpecialQuestion');
        Route::post('/QuestionInit/updateStatus/{id}', 'Admin\QuestionInitController@updateStatus');
        Route::get('/QuestionInit/{id}', 'Admin\QuestionInitController@show');
        Route::post('/QuestionInit/{id}', 'Admin\QuestionInitController@update');
        Route::post('/QuestionInit/Delete/{id}', 'Admin\QuestionInitController@destroy');
        Route::post('/QuestionInit/deleteAnswer/{id}', 'Admin\QuestionInitController@deleteAnswer');
        Route::post('/QuestionInit/showAnswerQuestionInit/{id}', 'Admin\QuestionInitController@showAnswerQuestionInit');

      ##ROUTEFORINSTALL##
      Route::get('/Question', 'Admin\QuestionController@index');
        Route::get('/Question/Lists', 'Admin\QuestionController@Lists');
        Route::post('/Question', 'Admin\QuestionController@store');
        Route::get('/Questionall', 'Admin\QuestionController@addQuestion');
        Route::get('/Question/{id}', 'Admin\QuestionController@show');
        Route::post('/Question/updateStatus/{id}', 'Admin\QuestionController@updateStatus');
        Route::post('/Question/{id}', 'Admin\QuestionController@update');
        Route::post('/Question/AnswerRight/{id}', 'Admin\QuestionController@AnswerRight');
        Route::post('/Question/Delete/{id}', 'Admin\QuestionController@destroy');

        Route::get('/Reward', 'Admin\RewardController@index');
        Route::get('/Reward/Lists', 'Admin\RewardController@Lists');
        Route::post('/Reward', 'Admin\RewardController@store');
        Route::post('/Reward/Import/{id?}', 'Admin\RewardController@Import');
        Route::post('/Reward/Export/{id?}', 'Admin\RewardController@Export');
        Route::get('/Reward/{id}', 'Admin\RewardController@show');
        Route::post('/Reward/{id}', 'Admin\RewardController@update');
        Route::post('/Reward/Delete/{id}', 'Admin\RewardController@destroy');

        #REPORT
        Route::get('/report',function(){
          $data['main_menu'] = 'รายงาน';
          $data['title_page'] = 'รายงาน';
          $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
          return view('Admin.report',$data);
        });
    });

    //Route::get('/Activities/randomReward/{aid}/{uid}/{result}', 'Admin\ActivitiesController@randomReward');
    Route::get('/Activities/randomReward/{code}', 'Admin\ActivitiesController@randomReward');
    Route::get('/ActivityRewardUser/accept/{id}/{result?}', 'Admin\ActivityRewardUserController@acceptRewardUser');

    //OrakUploader
    Route::any('/upload_file', 'OrakController@upload_file');

    //Laravel Filemanager
    Route::get('admin/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
    Route::post('admin/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');

    //Main Procress
    Route::get('/QRCODE/{code}', 'Admin\ActivitiesController@QRCODE');
    Route::post('/QRCODE', 'Admin\ActivitiesController@StoreQRCODE');
    Route::get('/Activities/{code}/{userid}/getQuestion', 'Admin\ActivitiesController@getQuestion');
    Route::get('/Activities/{code}/{userid}/getSpecialQuestion', 'Admin\ActivitiesController@getAllSpecialQuestion');
    Route::post('/AnswerHistory', 'Admin\ActivitiesController@storeHistory');
?>
