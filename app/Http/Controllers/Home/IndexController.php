<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/9
 * Time: 14:00
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Jobs\ArtCaiJi;
use QL\QueryList;
class IndexController extends Controller
{
    public function getIndex()
    {
        return home_view('index.index');
    }

    public function getQueue()
    {
        dump($this->dispatch(new ArtCaiJi()));
    }

    public function getCaiji()
    {
        $data = QueryList::run('Request',[
            'target' => 'https://www.zhihu.com/',
            'method' => 'get',
            'params' => ['username'=>'18655607203','password'=>'112861'],
            'cookiePath' => public_path().'cookie.txt'
            //更多参数查看Request扩展
        ])->setQuery(['link' => ['a.question_link','href']])->getData(function($item){
            return $item['link'];
        });

        echo '<pre>';
        print_r($data);
    }

    public function getEdit()
    {
        echo 'this is edit';
    }
}