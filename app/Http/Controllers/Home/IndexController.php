<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use DB;
use QL\QueryList;
use App\Models\Admin\Book;

class IndexController extends BaseController
{
    public function getIndex(Book $book)
    {
        $categorys = config('book.categorys');

        //最近更新
        $newLists = $book->lists([],'updated_at desc',50,false);
        if(count($newLists)) $newLists = $this->setCatname($newLists, $categorys);

        //最新入库
        $newInserts = $book->lists([],'id desc',50,false);
        if(count($newInserts)) $newInserts = $this->setCatname($newInserts, $categorys);

        //各分类推荐
        $tjLists = [];
        $i = 1;
        foreach($categorys as $k => $v){
            if($k == 9) break;
            $tjLists[$i]['catname'] = $v['name'];
            $tjLists[$i]['id'] = $k;
            $tjLists[$i]['data'] = $book->lists(['catid' => $k],'',7,false);
            $i++;
        }
        //封面推荐
        $ftLists = $book->lists([],'',6,false);
        $data = [
            'newLists'   => $newLists,
            'newInserts' => $newInserts,
            'tjLists'    => $tjLists,
            'ftLists'    => $ftLists,
        ];
        return home_view('index.index',$data);
    }

    public function getTest(Book $book)
    {

    }

    /**
     *
     * @param $data
     * @param $categorys
     * @return array
     */
    protected function setCatname($data, $categorys)
    {
        $new_data = [];
        foreach($data as $v){
            $v['catname'] = $categorys[$v['catid']]['name'];
            $new_data[] = $v;
        }
        return $new_data;
    }
}