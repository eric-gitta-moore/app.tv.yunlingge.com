<?php
namespace app\app\controller;

use app\XDeode;
use think\Controller;
class Nav extends Controller
{
    public function index()
    {
        $xzv_3 = input('cid');
        $xzv_2['vip'] = db('banner')->where('cid', 2)->order('sort asc')->paginate(999);
        $xzv_2['tj'] = db('banner')->where('cid', 4)->order('sort asc')->paginate(4);
        $xzv_2['banner'] = db('banner')->where('cid', 1)->order('sort asc')->paginate(4);
        $xzv_2['lr'] = db('banner')->where('cid', 3)->find();
        $xzv_2['wz'] = db('banner')->where('cid', 12)->order('sort asc')->paginate(2);
        $xzv_2['hb'] = db('banner')->where('cid', 8)->find();
        echo json_encode($xzv_2, JSON_UNESCAPED_UNICODE);
    }
    public function fl()
    {
        $xzv_1 = input('cid');
        $xzv_4['tu'] = db('banner')->where('cid', 6)->order('sort asc')->paginate(8);
        $xzv_4['banner'] = db('banner')->where('cid', 5)->order('sort asc')->paginate(4);
        $xzv_4['guanggao'] = db('banner')->where('cid', 7)->order('sort asc')->paginate(4);
        echo json_encode($xzv_4, JSON_UNESCAPED_UNICODE);
    }
    public function on()
    {
        $xzv_0 = db('advert')->select();
        echo json_encode($xzv_0, JSON_UNESCAPED_UNICODE);
    }
}