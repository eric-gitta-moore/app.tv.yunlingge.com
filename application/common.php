<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://yshy.mingdi.xyz All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( 客服QQ:481844984 客服VX：927857669 )
// +----------------------------------------------------------------------
// | Author: 明帝网络传媒 <VX927857669>
// +----------------------------------------------------------------------

function getIP()
{
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');

    } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getusercount($id)
{
    $count = db('user')->where(['parentid' => $id, 'power' => '1'])->count();
    return $count;
}

function getvipcount($id)
{
    $count = db('user')->where(['parentid' => $id, 'power' => '2'])->count();
    return $count;
}

function getRandomString($len, $chars = null, $type = false)
{

    if ($type == true) {
        $authnum = rand('100000', '999999');
        $count = db('user')->where('share_ma', $authnum)->count();
        if ($count > 0 || in_array($authnum, ['111111', '222222', '333333', '444444', '555555', '666666', '777777', '888888', '999999', '000000', '123456', '654321'])) {
            $authnum = getRandomString($len, $chars, $type);
        }
    } else {
        srand((double)microtime() * 1000000);//create a random number feed.
        $ychar = "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
        $list = explode(",", $ychar);
        $authnum = '';
        for ($i = 0; $i < 6; $i++) {
            $randnum = rand(0, 35); // 10+26;
            $authnum .= $list[$randnum];
        }
    }


    return $authnum;

}

function randstring($len)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str);
    $rands = md5(time() . $randStr);
    return substr($rands, 0, $len);

}

// 应用公共文件
function name()
{
    $id = session('user');
    $name = db('user')->where('id', $id)->value('username');
    return $name ? $name : '无数据';
}

function _name($id)
{
    $name = db('user')->where('id', $id)->value('username');
    return $name ? $name : '无数据';
}

function sname($id, $name)
{
    $name = db('user')->where('id', $id)->value($name);
    return $name ? $name : '无数据';
}


function power()
{
    $id = session('user');
    $name = db('user')->where('id', $id)->value('power');
    if ($name == '1') {
        return '代理';
    } else {
        return '管理员';
    }
}

function advert($id = null)
{
    if ($id != null) {
        $name = db('advert')-> cache(true)->where('id', $id)->value('content');

    } else {
        $name = db('advert')-> cache(true)->where('id', 1)->value('content');

    }
    return $name;
}

function gui($id)
{
    $name = db('user')->where('id', $id)->value('username');
    return $name;
}


function yue()
{
    $id = session('user');
    $power = session('power');
    if ($power == '1') {
        $where['id'] = $id;
    } else {
        $where = '';
        return '';
    }
    $name = db('user')->where($where)->value('money');
    return '当前提卡余额:' . $name;
}

function share()
{
    $id = session('user');
    $power = session('power');
    if ($power == '1') {
        $where['id'] = $id;
    } else {
        $where = '';
        return '';
    }
    $name = db('user')->where($where)->value('share_ma');
    return '分享码:' . $name;
}

