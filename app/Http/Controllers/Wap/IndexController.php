<?php
namespace App\Http\Controllers\Wap;
use App\Http\Controllers\Home\BaseController;

use App\Models\Admin\Book;

class IndexController extends BaseController
{
    public function getIndex(Book $book)
    {
        $categorys = config('book.categorys');

        //封面推荐
        $ftLists = \Cache::remember('wap.ftLists' , 600 ,function() use ($book) {
            return $book->ftlists([],'hits DESC',6)->toArray();
        });

        //各分类推荐
        $tjLists = \Cache::remember('wap.tjLists' , 600 ,function() use ($categorys,$book) {
            $tjLists = [];
            $i = 1;
            foreach($categorys as $k => $v){
                $tjLists[$i]['catname'] = $v['name'];
                $tjLists[$i]['id'] = $k;
                $tjLists[$i]['data'] = $book->lists(['catid' => $k],'thumb DESC,hits DESC',6,false)->toArray();
                $i++;
            }
            return $tjLists;
        });

        //最近更新
        $newLists = \Cache::remember('wap.newLists' , 60 , function() use($book,$categorys) {
            $newLists = $book->lists([],'thumb DESC,updated_at DESC',6,false);
            if(count($newLists)){
                $newLists = $this->setCatname($newLists->toArray() ,$categorys);
            }
            return $newLists;
        });

        //新书精选
        $newInserts = \Cache::remember('wap.newInsert' , 60 , function() use($book,$categorys) {
            $newInserts = $book->lists([],'thumb DESC,hits DESC',6,false);
            if(count($newInserts)){
                $newInserts = $this->setCatname($newInserts->toArray() ,$categorys);
            }
            return $newInserts;
        });

        $data = [
            'ftLists'    => $ftLists,
            'tjLists'    => $tjLists,
            'newLists'   => $newLists,
            'newInserts' => $newInserts,
        ];
        return wap_view('index.index',$data);
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