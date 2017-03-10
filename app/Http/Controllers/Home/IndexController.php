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
        echo 1;
    }

    public function getEdit()
    {
        echo date('Y-m-d H:i:s');
    }

    public function getTest()
    {
        $baseUrl = 'http://www.8dushu.com';
        $url = $baseUrl . '/sort1/1/';//玄幻
        $rules = [
            'title' => [
                '.sm a','text'
            ],
            'linkurl' => [
                '.sm a','href'
            ],
            'author'  => [
                '.zz ','text'
            ],
            'wordcount'=> [
                '.zs','text'
            ],
            'updatetime'=>[
                '.sj','text'
            ],
            'zhangjie' => [
                '.zj','text'
            ]
        ];
        $data = QueryList::Query($url,$rules,'','UTF-8','GBK',true);
        $data = $data->getData();
        foreach($data as &$v){
            if( isset($v['linkurl']) ){
                $v['linkurl'] = $baseUrl . $v['linkurl'];
            }
            $v['wordcount'] = preg_replace('/[^0-9]+/','',$v['wordcount']);
        }
        \File::put( public_path().'/caiji/data.php' , '<?php return ' . var_export($data,true) .';?>' );
        echo '生成列表数据成功';
    }

    public function getPost()
    {
        $data = include public_path('caiji/data.php');
//        foreach($data as $v)
//        {
//
//        }
        $item = $data['0'];
        //$this->dispatch(new ArtCaiJi($item));
        $rules = [
            'title' => [
                '.mulu li a' , 'text'
            ],
            'linkurl' => [
                '.mulu li a' , 'href'
            ],
        ];
        $result = QueryList::Query($item['linkurl'] , $rules , '' ,'UTF-8','GBK',true)->getData();
        foreach($result as &$v)
        {
            if(isset($v['linkurl'])){
                $v['linkurl'] = strpos($v['linkurl'],'http') === false ? $item['linkurl'] . $v['linkurl'] : $v['linkurl'];
            }
        }
        echo "<pre>";
        print_r($result);
    }
}