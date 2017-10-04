<?php
/*
 * 推送链接到搜索引擎
 * */
namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Foundation\Inspiring;

class PushLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushlink {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Link To SearchEngine';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $number = intval($this->argument('number'));
        $number = $number ? $number : 1500;

        $site = 'baidu';
        $searchEngine = \DB::table('linksubmit')->where('site', $site)->first();

        $bookDetailLists = \DB::table('books_detail')->select('id','pid')->where('status',1)->where('id','>',$searchEngine['detailid'])->orderBy('id','ASC')->take($number)->get();

        if(empty($bookDetailLists)){
            $this->info(date('Y-m-d H:i:s').' 未发现待上传链接');
            return true;
        }

        $bookids = array_unique(array_column($bookDetailLists , 'pid'));

        $bookListsTmp = \DB::table('books')->select('id','catid')->whereIn('id',$bookids)->get();

        $bookLists = $urls = [];
        foreach($bookListsTmp as $v){
            $bookLists[$v['id']] = $v;
            $urls[] = bookurl($v['catid'],$v['id']);
        }

        foreach($bookDetailLists as $v){
            $urls[] = bookurl($bookLists[$v['pid']]['catid'] , $v['pid'] , $v['id']);
        }
        $detailID = $v['id'];

        $urls = array_map(function($v){
            $v = str_replace(url() , env('SITE_DOMAIN') , $v);
            return $v;
        } , $urls);

        $wapUrls = array_map(function($v){
            $v = str_replace(env('SITE_DOMAIN') , env('APP_MOBILE_DOMAIN') , $v);
            return $v;
        } , $urls);

        //$this->info(var_export($urls));
        //$this->info(var_export($wapUrls));
        switch($site){
            case 'baidu':
                $response = json_decode(post_url_to_baidu($urls), true);
                if($response && isset($response['success'])){
                    $message = '成功推送 [PC端]: ' . $response['success'] . '个';
                    $secondResponse = json_decode(post_url_to_baidu($wapUrls,'wap'), true);
                    if($secondResponse && isset($secondResponse['success'])){
                        $message .= ' , [WAP端]: ' . $secondResponse['success'] . '个';
                    }else{
                        \Log::debug('-- LINK SUBMIT FAIL [PC] -- ' . var_export($secondResponse , true));
                        $message .= ' , [WAP端] 推送失败，('.$secondResponse['error'].')' . $secondResponse['message'];
                    }
                }else{
                    \Log::debug('-- LINK SUBMIT FAIL [PC] -- ' . var_export($response , true));
                    $message = '推送失败 : ('.$response['error'].')' . $response['message'];
                }
                $this->info($message);
                break;
            default:

                break;
        }

        \DB::table('linksubmit')->where('site', $site)->update([
            'detailid'   => $detailID ,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return true;
    }
}
