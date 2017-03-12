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
            if( !empty($v['linkurl']) ){
                $v['linkurl'] = $baseUrl . $v['linkurl'];
            }
            $v['wordcount'] = preg_replace('/[^0-9]+/','',$v['wordcount']);

            if( !empty($v['title']) ){

                $item = DB::table('books')->where('title',trim($v['title']))->first();

                if($item){

                    DB::table('books')->where('id',$item->id)->update([
                        'wordcount' => $v['wordcount'],
                        'zhangjie'  => $v['zhangjie'],
                    ]);
                    $v['id'] = $item->id;

                }else{

                    $id = DB::table('books')->insertGetId([
                        'catid' => 0,
                        'title' => $v['title'],
                        'introduce' => '',
                        'zhangjie'  => $v['zhangjie'],
                        'author'=> $v['author'],
                        'wordcount' => $v['wordcount'],
                        'follow'    => 0,
                        'hits'      => 0,
                        'status'    => 0,
                        'created_at'=> date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s'),
                    ]);
                    $v['id'] = $id;

                }
                //推送到任务队列
                $this->dispatch(new ArtCaiJi($v));
                break;
            }

        }
        \File::put( public_path().'/caiji/data.php' , '<?php return ' . var_export($data,true) .';?>' );
        echo '生成列表数据成功';
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