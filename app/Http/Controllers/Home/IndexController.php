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


        $newLists = $book->lists([],'updated_at desc',50,false);
        if(count($newLists)) $newLists = $this->setCatname($newLists, $categorys);


        $newInserts = $book->lists([],'id desc',50,false);
        if(count($newInserts)) $newInserts = $this->setCatname($newInserts, $categorys);

        $tjLists = [];
        $i = 1;
        foreach($categorys as $k => $v){
            if($k == 9) break;
            $tjLists[$i]['catid'] = $v['id'];
            $tjLists[$i]['catname'] = $v['name'];
            $tjLists[$i]['id'] = $k;
            $tjLists[$i]['data'] = $book->lists(['catid' => $k],'',7,false);
            $i++;
        }

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
        $baseUrl = 'http://www.8dushu.com';
        $url = $baseUrl . '/sort1/1/';
        $rules = [
            'title' => [
                '.sm a','text'
            ],
            'fromurl' => [
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
        ];//列表页采集规则

        $result = QueryList::Query($url,$rules,'.booklist>ul>li','UTF-8','GBK',true)->getData();

        echo "<pre>";
        print_r($result);
        exit();
        $this->Book = $book->find(1);
        if( $this->Book['fromurl'] && $this->Book['id'] ){

            //更新文章详情 / 缩略图
            if(empty($this->Book['introduce']) || empty($this->Book['thumb'])){

                $rules = [
                    'introduce' => [
                        '.intro','text'
                    ],
                    'thumb' => [
                        '.lf img','src'
                    ],
                ];
                $html = QueryList::Query($this->Book['fromurl'] , $rules , '' ,'UTF-8','GBK',true);
                $bookInfo = $html->getData();

                $updateData = [];
                if(empty($this->Book['introduce']) && !empty($bookInfo[0]['introduce'])){
                    $updateData['introduce'] = $bookInfo[0]['introduce'];
                }

                if(empty($this->Book['thumb']) && !empty($bookInfo[0]['thumb']) && strpos($bookInfo[0]['thumb'],'nocover.jpg') === false){
                    $thumb = save_remote_thumb($bookInfo[0]['thumb']);
                    $updateData['thumb'] = $thumb;
                }
                if(count($updateData)){
                    DB::table('books')->where('id',$this->Book['id'])->update($updateData);
                }
            }

            //获取章节列表
            $rules = config('book.rules.88dushu.detail_list');
            $book = $html->setQuery($rules);
            $booksDetailLists = $book->getData();

            if(count($booksDetailLists)){

                $baseUrl = $this->Book['fromurl'];

                foreach($booksDetailLists as $k => &$v){
                    $v = array_map('trim',$v);
                    if(empty($v['fromurl'])){
                        unset($booksDetailLists[$k]);
                    }else{
                        if(substr($v['fromurl'],0,4) !== 'http'){
                            $v['fromurl'] = $baseUrl . $v['fromurl'];
                        }
                    }
                }

                $lastArticle = $this->getLastArticle($this->Book['id']);

                if($lastArticle){
                    $offset = 0;
                    foreach($booksDetailLists as $k => $v)
                    {
                        if($v['title'] == $lastArticle->title){
                            $offset = $k;
                            break;
                        }
                    }
                    //从最后一个章节开始截取10章
                    $links = array_slice($booksDetailLists, $offset+1 , $this->Count);
                }else{
                    $links = array_slice($booksDetailLists, 0 , $this->Count);
                }


            }
        }
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