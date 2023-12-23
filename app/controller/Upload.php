<?php

namespace app\controller;

use think\Facade\Request;

class Upload
{

    public function __construct(){
        
    }
    public function index()
    {
        $files = request()->file('files');

        foreach ($files as $file) {
            $ext = $file->getOriginalExtension();
            //不同文件，储存不同的文件夹
            $folder = config('filesystem.disks.folder') . '/uploads/' . $ext; //以文件后缀名作为存文件的存放目录
            if (!file_exists($folder))
                mkdir($folder, 0700, TRUE); //如果文件夹不存在，则创建


            $savename = \think\facade\Filesystem::disk('public')
                ->putFile('', $file, 'md5'); //上传文件，得到上传之后的文件名称

            if (!$savename) {
                return 0;
            } else {
                $savename = '' . str_replace("\\", "/", $savename);
                if ($savename) {
                    return Request::domain() . '/uploads/' . $savename;
                }
            }
        }
    }
}
