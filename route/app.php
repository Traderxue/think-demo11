<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');


Route::group("/user", function () {

    Route::post("/register", "user/register");

    Route::post("/login", "user/login");

    Route::put("/disabled", "user/disabled");

    Route::get("/getById", "user/getById");

    Route::get("/page", "user/page");

    Route::post("/edit", "user/edit");
});
