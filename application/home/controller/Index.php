<?php

namespace app\home\controller;

// ? 引用tp的基础控制器

use think\captcha\Captcha;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function __construct()
    {
        // 手动继承父级
        parent::__construct();

        $this->UserModel = model('User.User');

    }


    public function index()
    {
        return view();
    }

    // ? 登录
    public function login()
    {
        if ($this->request->isPost()) {
            // todo 接收参数
            $formData = $this->request->param();

            if (!captcha_check($formData['vercode'])) {
                $this->error('验证码错误');
            }

            // todo 根据邮箱查询数据库，where里面使用[]用可用于多条件查询，键值对形式用于单条件查询
            $User = $this->UserModel->where(['email' => $formData['email']])->find();

            if (!$User) {
                $this->error('用户不存在');
            }

            $password = md5($formData['pass'] . $User['salt']);

            if ($password != $User['password']) {
                $this->error('密码不正确');
            }


            // todo 设置cookie
            // $dataList = [
            //     'id' => $User['id'],
            //     'email' => $User['email'],
            //     'nickname' => $User['nickname'],
            //     'vip' => $User['vip'],
            //     'auth' => $User['auth'],
            //     'sex' => $User['sex'],
            //     'sex_text' => $User['sex_text'],
            //     'point' => $User['point'],
            //     'avatar' => $User['avatar'] ? $User['avatar'] : '/static/home/res/images/avatar/default.png',
            //     'cover' => $User['cover'] ? $User['cover'] : '/static/home/res/images/back_1.jpg',
            // ];
            $dataList = md5($User['id'].$User['salt']);

            cookie('LoginUser',$dataList);

            $this->success('登录成功',url('home/user/index'));
        }

        // todo 输出视图
        return $this->fetch();
    }

    // ? 注册
    public function register()
    {
        if ($this->request->isPost()) {
            // todo 接收get、post参数
            $formData = $this->request->param();

            // ! 尽量避免直接修改$_GET或者$_POST还有param
            // $this->request->post(['nickname'=>'898989']);

            // halt(input('post.nickname'));
            // halt($formData);

            if (!captcha_check($formData['vercode'])) {
                // todo 验证码错误跳转
                $this->error('验证码错误', null, 1);
            }

            // todo 判断密码和确认密码是否一致
            if ($formData['pass'] != $formData['repass']) {
                $this->error('密码和确认密码不一致');
            }

            // todo 生成密码盐
            $salt = build_ranstr();

            // todo 加密
            $password = md5($formData['pass'] . $salt);

            // todo Db类挥着模型CRUD，
            $point = Db::name('config')->where('key', 'RegisterPoint')->value('value');
            // halt($point);

            // todo 封装提交数据
            $dataList = [
                'email' => $formData['email'],
                'nickname' => $formData['nickname'],
                'password' => $password,
                'salt' => $salt,
                'sex' => 0,
                'auth' => 0,
                'vip' => 1,
                'point' => $point
            ];

            // todo 使用模型验证器
            $result = $this->UserModel->validate('common/User/User')->save($dataList);

            if ($result === FALSE) {
                $this->error($this->UserModel->getError());
            } else {
                $this->success('注册成功', url('home/index/login'));
            }
        }
        // todo 输出视图
        return $this->fetch();
    }

    // ? 验证码
    public function vercode()
    {
        $config = [
            'length' => 4,
            // 验证码字体大小
            'fontSize' => 20,
            'imageW' => 150,
            'imageH' => 40
        ];
        $captcha = new Captcha($config);

        return $captcha->entry();
    }
}
