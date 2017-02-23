<?php
/**
 * Note:
 * User: Liu
 * Date: 2017/2/23
 */
namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Log;

class ServerController extends Controller
{
    public function getIndex()
    {
        Log::info('Wechat Debug Start');
        $wechat = app('EasyWechat');
        $wechat->server->setMessageHandler(function($Message){
            return '还原管';
        });
        $wechat->server->serve();
    }
}