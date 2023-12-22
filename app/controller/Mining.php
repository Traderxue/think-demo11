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

    public function remove($id)
    {
        $mining = MiningModel::where("id", $id)->find();
        $res = $mining->save([
            "status" => 1
        ]);

        if ($res) {
            return $this->result->success("矿机已下架", $res);
        }
        return $this->result->error("数据编辑失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page");
        $pageSize = $request->param("pageSize");
        $name = $request->param("name");

        $list = MiningModel::where("name", $name)->paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);

        return $this->result->success("获取数据成功", $list);
    }

    public function edit(Request $request)
    {
        $post = $request->post();
        $mining = MiningModel::where("id", $post["id"])->find();

        $res = $mining->save([
            "avatar" => $post["avatar"]
        ]);

        if ($res) {
            return $this->result->success("编辑数据成功", $res);
        }
        return $this->result->error("编辑数据失败");
    }
}
