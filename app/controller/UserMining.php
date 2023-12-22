<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\UserMining as UserMiningModel;
use app\model\Mining as MiningModel;
use app\util\Res;

class UserMining extends BaseController
{
    protected $result;

    public function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    public function add(Request $request)
    {
        $post = $request->post();
        $currentDateTime = date("Y-m-d  H:i:s");

        $expirationTime = date("Y-m-d H:i:s", strtotime($currentDateTime . " +30 days"));

        $mining  = MiningModel::where("id", $post["mining_id"])->find();

        $profit = ($mining->rate * $mining->price) * $post["num"];

        $user_mining = new UserMiningModel([
            "u_id" => $post["u_id"],
            "mining_id" => $post["mining_id"],
            "buy_time" => date("Y-m-d H:i:s"),
            "maturity_time" => $expirationTime,
            "profit" => $profit,
            "num" => $post["num"]
        ]);

        $res = $user_mining->save();

        if ($res) {
            return $this->result->success('添加数据成功', $user_mining);
        }
        return $this->result->error("添加数据失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page");
        $pageSize = $request->param("pageSize");
        $list = UserMiningModel::paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);
        return $this->result->success("获取数据成功", $list);
    }
}
