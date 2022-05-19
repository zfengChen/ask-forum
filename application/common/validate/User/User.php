<?php

namespace app\common\validate\User;

use think\Validate;

// todo 用户验证器
class User extends Validate
{
  /**
   * 定义验证规则
   * 格式：'字段名' =>  ['规则1','规则2'...]
   *
   * @var array
   */
  protected $rule = [
    //email字段，必须是必填、邮箱类型、唯一的对照user表
    'email' => 'require|email|unique:user',
    'password' => 'require', //必填
    'salt' => 'require', //必填
    'nickname' => 'require', //必填
    'sex' => 'in:0,1,2',  //给字段设置范围
    'point' => 'egt:0',  //给字段设置 >= 0
    'vip' => 'egt:0',  //给字段设置 >= 0
    'auth' => 'in:0,1',  //给字段设置范围
    'openid' => 'unique:user', //openid必须是唯一的
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名' =>  '错误信息'
   *
   * @var array
   */
  protected $message = [
    'email.require' => '邮箱必填',
    'email.email' => '格式必须是邮箱',
    'email.unique' => '该邮箱已注册，请重新填写',
    'nickname.require'  => '昵称必填',
    'password.require' => '密码必填',
    'salt.require' => '密码盐生成有误，请稍后重试',
    'sex.in' => '选择的性别有误，请重新选择',
    'point.egt' => '积分不能小于0',
    'vip.egt' => 'vip等级不能小于0',
    'auth.in' => '您的验证状态有误请重新操作',
  ];
}
