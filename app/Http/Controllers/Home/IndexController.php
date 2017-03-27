<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use DB;

use App\Models\Admin\Book;

class IndexController extends Controller
{
    public function getIndex(Book $book)
    {
        $categorys = config('book.categorys');


        $newLists = $book->lists([],'updated_at desc',50,false);
        if(count($newLists)) $newLists = $this->setCatname($newLists, $categorys);


        $newInserts = $book->lists([],'id desc',50,false);
        if(count($newInserts)) $newInserts = $this->setCatname($newInserts, $categorys);

        $tjLists = [];
        $i = 1;
        foreach($categorys as $k => $v){
            if($k == 9) break;
            $tjLists[$i]['catname'] = $v['name'];
            $tjLists[$i]['id'] = $k;
            $tjLists[$i]['data'] = $book->lists(['catid' => $k],'',7,false);
            $i++;
        }

        $ftLists = $book->lists([],'',6,false);
        $data = [
            'categorys'  => $categorys,
            'newLists'   => $newLists,
            'newInserts' => $newInserts,
            'tjLists'    => $tjLists,
            'ftLists'    => $ftLists,

        ];
        return home_view('index.index',$data);
    }

    public function getTest()
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