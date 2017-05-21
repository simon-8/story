<?php
namespace App\Http\Controllers\Home;

use App\Models\Admin\Book;
use App\Models\Admin\Links;

use QL\QueryList;
use DB;
use App\Jobs\Books\Wx999Content;
class IndexController extends BaseController
{
    public function getIndex(Book $book)
    {
        $categorys = config('book.categorys');

        //最近更新
        $newLists = \Cache::remember('newLists' , 60 , function() use($book,$categorys) {
            $newLists = $book->lists([],'updated_at desc',50,false);
            if(count($newLists)){
                $newLists = $this->setCatname($newLists->toArray() ,$categorys);
            }
            return $newLists;
        });
        //最新入库
        $newInserts = \Cache::remember('newInsert' , 60 , function() use($book,$categorys) {
            $newInserts = $book->lists([],'id desc',50,false);
            if(count($newInserts)){
                $newInserts = $this->setCatname($newInserts->toArray() ,$categorys);
            }
            return $newInserts;
        });

        //各分类推荐
        $tjLists = \Cache::remember('tjLists' , 600 ,function() use ($categorys,$book) {
            $tjLists = [];
            $i = 1;
            foreach($categorys as $k => $v){
                if($k == 9) break;
                $tjLists[$i]['catname'] = $v['name'];
                $tjLists[$i]['id'] = $k;
                $tjLists[$i]['data'] = $book->lists(['catid' => $k],'',7,false)->toArray();
                $i++;
            }
            return $tjLists;
        });

        //封面推荐
        $ftLists = \Cache::remember('ftLists' , 600 ,function() use ($book) {
            return $book->ftlists([],'hits DESC',6)->toArray();
        });

        //firendLinks
        $firendLinks = \Cache::remember('firendLinks', 600, function(){
            $links = new Links();
            return $links->lists();
        });

        $data = [
            'newLists'   => $newLists,
            'newInserts' => $newInserts,
            'tjLists'    => $tjLists,
            'ftLists'    => $ftLists,
            'firendLinks'=> $firendLinks,
        ];
        return home_view('index.index',$data);
    }

    public function getTest(Book $book)
    {
        header('content-type:text/html;charset=utf-8');
        $rules = [
            'content' => [
                //过滤div和p标签
                '#box','text','-p -div -script'
            ]
        ];
        $url = 'http://www.999wx.com//article/7/41200/14950661.shtml';
        $html = request_spider($url);
        //echo $html;
        $result = QueryList::Query($html , $rules , '' ,'UTF-8','GBK',true)->getData();
        echo "<pre>";
        print_r($result);
    }

    /**
     *
     * @param $data
     * @param $categorys
     * @return array
     */
    protected function setCatname($data , $categorys)
    {
        $new_data = [];
        foreach($data as $v){
            $v['catname'] = $categorys[$v['catid']]['name'];
            $new_data[] = $v;
        }
        return $new_data;
    }
}