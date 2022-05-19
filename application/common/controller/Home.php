<?php

namespace app\common\controller;

use think\Controller;

class Home extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->UserModel = model('User.User');

        // todo 获取cookie数据
        $LoginUser = cookie('LoginUser') ? cookie('LoginUser') : '';

        // todo 登录拦截
        if (empty($LoginUser)) {
            $this->error('请先登录', url("home/index/login"));
        }

        /** 
         * todo 通过cookie里的加密信息与数据库拿出来的数据加密对比
         * todo 来判断是否有登录
         * 
         *  ? $UserList = model('User.User')->column('id,salt');
         */
        $dataList = $this->UserModel->select();

        
        $UserId = '';
        foreach ($dataList as $item) {
            $temp = md5($item['id'] . $item['salt']);

            if ($LoginUser == $temp) {
                $UserId = $item['id'];
                break;
            }
        }
        // halt($UserId);

        /** 
         *  TODO 重新通过id号查询数据，保证数据的最新性。 
         */
        $UserData = $this->UserModel->where(['id'=>$UserId])->find();

        if (!$UserData) {
            cookie('LoginUser',null);
            $this->error('非法登录',url('home/index/login'));
        }


        // TODO 重新指定新的属性，在其他控制器里继承该属性便可以使用
        $this->LoginUser = $UserData;

        // TODO 赋值视图
        $this->assign([
            'LoginUser' => $UserData
        ]);
    }
}
