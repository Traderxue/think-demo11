<?php

namespace app\controller;

use think\Request;
use app\model\Mining as MiningModel;
use app\util\Res;
use app\BaseController;

class Mining extends MiningModel
{
    protected $result;

    public function __construct()
    {
        $this->result = new Res();
    }

    public function add(Request $request)
    {
        $post = $request->post();

        $mining = new MiningModel([
            "name" => $post["name"],
            "rate" => $post["rate"],
            "cycle" => $post["cycle"],
            "price" => $post["price"],
            "num" => $post["num"],
            "hash" => $post["hash"],
        ]);
        $res = $mining->save();
        if ($res) {
            return $this->result->success("添加矿机成功", $res);
        }
        return $this->result->error("添加矿机失败");
    }
}
