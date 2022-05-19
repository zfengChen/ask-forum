<?php

namespace app\common\model\User;

use think\Model;

class User extends Model
{
    // todo 设置数据表 => 用户表
    protected $table = 'pre_user';
    protected $autoWriteTimestamp  = true;

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;

    // TODO 因为在获取时间戳的时候，tp5底层自动将时间戳转成Y-m-d H:m:s格式，不需要H:m:s，就追加一个新的字段
    protected $dataFormat = "Y-m-d";

    // 追加字段
    protected $appnd = [
        'sex_text',
        'avatar_cdn',
        'cover_cdn'
    ];

    // 设置不存在字段
    public function getSexTextAttr($value, $data)
    {
        $SexList = [
            0 => '保密',
            1 => '男',
            2 => '女'
        ];

        return $SexList[$data['sex']];
    }

    // 头像
    public function getAvatarCdnAttr($value, $data)
    {
        $avatar = @is_file('.'.$data['avatar']) ? $data['avatar'] : '/static/home/res/images/avatar/default.png';

        $cdn = config('cdn');

        return $cdn . $avatar;
    }

    // 背景
    public function getCoverCdnAttr($value, $data)
    {
        $cover = @is_file('.'.$data['cover']) ? $data['cover'] : '/static/home/res/images/back_1.jpg';

        $cdn = config('cdn');

        return $cdn . $cover;
    }
}
