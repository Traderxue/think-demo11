<?php

namespace app\controller;

use think\facade\Request;
use think\facade\Filesystem;

class Upload
{
    function index()
    {
        $file = request()->file('file');
        $savename = Filesystem::disk("public")->putFile("topic", $file, "md5");
        if (!$savename) {
            return null;
        } else {
            $savename = '' . str_replace("\\", "/", $savename);
            return Request::domain() . '/uploads/' . $savename;
        }
    }
}
