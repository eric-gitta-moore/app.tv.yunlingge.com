<?php

namespace app\index\controller;

use think\Controller;
class Dianka extends Controller
{
    public function _initialize()
    {
        $xzv_25 = session('user');
        if (!$xzv_25) {
            $this->redirect('login/login/index');
        }
    }
    public function index()
    {
        $xzv_16 = input('dian');
        if (empty($xzv_16)) {
            $xzv_16 = [];
        }
        return view('index', ['dian' => $xzv_16]);
    }
    public function ylog()
    {
        if (session('power') == '0') {
            $xzv_30['y'] = '0';
        } else {
            $xzv_30['uid'] = session('user');
            $xzv_30['y'] = '0';
        }
        if (input('user')) {
            $xzv_18 = input('user');
            $xzv_30['dianka'] = ['like', "%{$xzv_18}%"];
        }
        if (input('start') && input('end')) {
            $xzv_30['ctime'] = ['between', strtotime(input('start') . ' 00:00:00') . ',' . strtotime(input('end') . ' 00:00:00')];
        } else {
            if (input('start')) {
                $xzv_30['ctime'] = ['>', strtotime(input('start') . ' 00:00:00')];
            }
            if (input('end')) {
                $xzv_30['ctime'] = ['<', strtotime(input('end') . ' 00:00:00')];
            }
        }
        if (input('day')) {
            $xzv_30['name'] = input('day');
        }
        $xzv_22 = db('dianka')->where($xzv_30)->paginate(20);
        return view('ylog', ['start' => input('start'), 'day' => input('day'), 'end' => input('end'), 'user' => input('user'), 'list' => $xzv_22]);
    }
    public function slog()
    {
        if (session('power') == '0') {
            $xzv_2['y'] = '1';
        } else {
            $xzv_2['uid'] = session('user');
            $xzv_2['y'] = '1';
        }
        if (input('user')) {
            $xzv_29 = input('user');
            $xzv_2['dianka'] = ['like', "%{$xzv_29}%"];
        }
        $xzv_21 = db('dianka')->where($xzv_2)->paginate(20);
        return view('slog', ['list' => $xzv_21]);
    }
    public function sheng()
    {
        if (input('fen') && input('ctime')) {
            $xzv_11 = ceil(input('fen'));
            $p = '/^[0-9]{0,100}$/';
          	preg_match($p, $xzv_11, $arr);
          	if(empty($arr)){
        	 $xzv_99 = ['code' => 0, 'dian' => '请勿试用特殊符号'];
             return json($xzv_99);
            }
            $xzv_4 = input('ctime');
            $xzv_12 = '0';
            switch ($xzv_4) {
                case 0.1:
                    $xzv_5 = 7 * 60 * 60 * 24;
                    $xzv_28 = '体验卡';
                    break;
                case 0.5:
                    $xzv_5 = 30 * 60 * 60 * 24;
                    $xzv_28 = '月卡';
                    break;
                case 10:
                    $xzv_5 = 90 * 60 * 60 * 24;
                    $xzv_28 = '季卡';
                    break;
                case 1:
                    $xzv_5 = 180 * 60 * 60 * 24;
                    $xzv_28 = '半年卡';
                    break;
                case 2:
                    $xzv_5 = 365 * 60 * 60 * 24;
                    $xzv_28 = '年卡';
                    break;
                case 10:
                    $xzv_12 = 1;
                    $xzv_5 = 0;
                    $xzv_28 = '永久';
                    break;
            }
            $xzv_7 = '';
            if (session('power') == '0') {
                for ($xzv_27 = 0; $xzv_27 < $xzv_11; $xzv_27++) {
                    $xzv_26 = randstring(8);
                    $xzv_31['uid'] = session('user');
                    $xzv_31['dianka'] = $xzv_26;
                    $xzv_31['ctime'] = time();
                    $xzv_31['y'] = 0;
                    $xzv_31['yid'] = '';
                    $xzv_31['time'] = $xzv_5;
                    $xzv_31['type'] = $xzv_12;
                    $xzv_31['name'] = $xzv_28;
                    db('dianka')->insert($xzv_31);
                    $xzv_7 .= $xzv_26 . '<br><hr>';
                }
            } else {
                $xzv_1 = db('user')->where('id', session('user'))->value('money');
                if ($xzv_1 < $xzv_11 * $xzv_4) {
                    $xzv_13 = ['code' => 0, 'dian' => '余额不足'];
                    return json($xzv_13);
                }
                $xzv_7 = '';
                for ($xzv_27 = 0; $xzv_27 < $xzv_11; $xzv_27++) {
                    $xzv_26 = randstring(8);
                    $xzv_31['uid'] = session('user');
                    $xzv_31['dianka'] = $xzv_26;
                    $xzv_31['ctime'] = time();
                    $xzv_31['y'] = 0;
                    $xzv_31['yid'] = '';
                    $xzv_31['time'] = $xzv_5;
                    $xzv_31['type'] = $xzv_12;
                    $xzv_31['name'] = $xzv_28;
                    db('dianka')->insert($xzv_31);
                    $xzv_7 .= $xzv_26 . '<br><hr>';
                }
                db('user')->where('id', session('user'))->update(['money' => $xzv_1 - $xzv_11 * $xzv_4]);
            }
        } else {
            $xzv_7 = '';
        }
        if (empty($xzv_3)) {
            $xzv_13 = ['code' => 1, 'dian' => $xzv_7];
        } else {
            $xzv_13 = ['code' => 0, 'dian' => $xzv_7];
        }
        return json($xzv_13);
    }
    public function dangesheng()
    {
        if (input('fen') && input('ctime')) {
            $xzv_14 = ceil(input('fen'));
            $xzv_9 = input('ctime');
            $xzv_23 = '0';
            switch ($xzv_9) {
                case 0.1:
                    $xzv_24 = 7 * 60 * 60 * 24;
                    $xzv_0 = '体验卡';
                    break;
                case 0.5:
                    $xzv_24 = 30 * 60 * 60 * 24;
                    $xzv_0 = '月卡';
                    break;
                case 3:
                    $xzv_24 = 90 * 60 * 60 * 24;
                    $xzv_0 = '季卡';
                    break;
                case 1:
                    $xzv_24 = 180 * 60 * 60 * 24;
                    $xzv_0 = '半年卡';
                    break;
                case 2:
                    $xzv_24 = 365 * 60 * 60 * 24;
                    $xzv_0 = '年卡';
                    break;
                case 10:
                    $xzv_23 = 1;
                    $xzv_24 = 0;
                    $xzv_0 = '永久';
                    break;
            }
            $xzv_6 = '';
            if (session('power') == '0') {
                for ($xzv_20 = 0; $xzv_20 < $xzv_14; $xzv_20++) {
                    $xzv_17 = randstring(8);
                    $xzv_19['uid'] = session('user');
                    $xzv_19['dianka'] = $xzv_17;
                    $xzv_19['ctime'] = time();
                    $xzv_19['y'] = 0;
                    $xzv_19['yid'] = '';
                    $xzv_19['time'] = $xzv_24;
                    $xzv_19['type'] = $xzv_23;
                    $xzv_19['name'] = $xzv_0;
                    db('dianka')->insert($xzv_19);
                    $xzv_6 .= $xzv_17;
                }
            } else {
                $xzv_10 = db('user')->where('id', session('user'))->value('money');
                if ($xzv_10 < $xzv_14 * $xzv_9) {
                    $xzv_8 = ['code' => 0, 'dian' => '余额不足 请充值'];
                    return json($xzv_8);
                }
                $xzv_6 = '';
                for ($xzv_20 = 0; $xzv_20 < $xzv_14; $xzv_20++) {
                    $xzv_17 = randstring(8);
                    $xzv_19['uid'] = session('user');
                    $xzv_19['dianka'] = $xzv_17;
                    $xzv_19['ctime'] = time();
                    $xzv_19['y'] = 0;
                    $xzv_19['yid'] = '';
                    $xzv_19['time'] = $xzv_24;
                    $xzv_19['type'] = $xzv_23;
                    $xzv_19['name'] = $xzv_0;
                    db('dianka')->insert($xzv_19);
                    $xzv_6 .= $xzv_17;
                }
                db('user')->where('id', session('user'))->update(['money' => $xzv_10 - $xzv_14 * $xzv_9]);
            }
        } else {
            $xzv_6 = '';
        }
        if (empty($xzv_15)) {
            $xzv_8 = ['code' => 1, 'dian' => $xzv_6];
        } else {
            $xzv_8 = ['code' => 0, 'dian' => $xzv_6];
        }
        return json($xzv_8);
    }
}