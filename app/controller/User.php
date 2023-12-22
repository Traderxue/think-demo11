<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;
use app\util\Res;

class User extends BaseController
{
    protected $result;

    public function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    public function register(Request $request)
    {
        $post = $request->post();

        $u = UserModel::where("username", $post["username"])->find();

        if ($u) {
            return $this->result->error("用户已存在");
        }

        $user = new UserModel([
            "username" => $post["username"],
            "password" => password_hash($post["password"], PASSWORD_DEFAULT),
            "email" => $post["email"],
            "invite_code" => $post["invite_code"],
        ]);

        $res = $user->save();

        if ($res) {
            return $this->result->success("注册成功", $user);
        }
        return $this->result->error("注册失败");
    }

    public function login(Request $request)
    {
        $username = $request->post("username");
        $password = $request->post("password");

        $user = UserModel::where("username", $username)->find();

        if (password_verify($password, $user->password)) {
            return $this->result->success("登录成功", $user);
        }
        return $this->result->error("登录失败");
    }


    public function disabled($id)
    {
        $user = UserModel::where("id", $id)->find();

        $res = $user->save([
            "status" => 1
        ]);

        if ($res) {
            return $this->result->success("用户禁用成功", $res);
        }
        return $this->result->error("用户禁用失败");
    }

    public function getById($id)
    {
        $user = UserModel::where("id", $id)->find();
        return $this->result->success("获取数据成功", $user);
    }

    public function page(Request $request)
    {
        $page = $request->param("page");
        $pageSize = $request->param("pageSzie");
        $username = $request->param("username");

        $list = UserModel::where("username", "like", "%{$username}%")->paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);

        return $this->result->success("获取数据成功", $list);
    }
}
