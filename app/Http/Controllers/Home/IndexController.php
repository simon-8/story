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
use DB;
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

        $rules = [
            'introduce' => [
                '.intro','text'
            ],
        ];
        $linkurl = 'http://www.8dushu.com/xiaoshuo/71/71986/';
        $html = QueryList::Query($linkurl , $rules , '' ,'UTF-8','GBK',true);

        //获取章节列表
        $rules = [
            'title' => [
                '.mulu li a' , 'text'
            ],
            'linkurl' => [
                '.mulu li a' , 'href'
            ],
        ];
        $book = $html->setQuery($rules);
        $booksDetailLists = $book->getData();

        $offset = 0;
        $title = '第八十四章：身份转变，古尔丹召见';
        foreach($booksDetailLists as $k => $v)
        {
            $v = array_map('trim',$v);
            if(!empty($v['linkurl']) && $v['title'] == $title){
                $offset = $k;
                break;
            }
        }
        $links = array_slice($booksDetailLists, $offset+1 , 10);
        $tmp = array_map(function($v) use ($linkurl){
            if(substr($v['linkurl'],0,4) !== 'http'){
                $v['linkurl'] = $linkurl . $v['linkurl'];
            }
            return $v;
        },$links);
        dd($tmp);

    }

    public function getPost($item)
    {
        $data = include public_path('caiji/data.php');
//        foreach($data as $v)
//        {
//
//        }
        $item = array_shift($data);
        //$this->dispatch(new ArtCaiJi($item));

        //获取小说相关信息
        $rules = [
            'introduce' => [
                '.intro','text'
            ],
        ];
        $html = QueryList::Query($item['linkurl'] , $rules , '' ,'UTF-8','GBK',true);
        $bookInfo = $html->getData();
        $introduce = $bookInfo[0]['introduce'];

        DB::table('books')->where('id',$item['id'])->update([
            'introduce' => $item['introduce'],
        ]);
        //获取章节列表
        $rules = [
            'title' => [
                '.mulu li a' , 'text'
            ],
            'linkurl' => [
                '.mulu li a' , 'href'
            ],
        ];
        $book = $html->setQuery($rules);
        $booksDetailLists = $book->getData();
        foreach($booksDetailLists as &$v)
        {
            if(isset($v['linkurl'])){
                $v['linkurl'] = strpos($v['linkurl'],'http') === false ? $item['linkurl'] . $v['linkurl'] : $v['linkurl'];
            }
        }
        echo "<pre>";
        dd($booksDetailLists);

        $detail = array_shift($booksDetailLists);
        $html = QueryList::Query($detail['linkurl'] , $rules , '' ,'UTF-8','GBK',true);

    }
}