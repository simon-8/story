<?php
/**
 * Note: 系统配置
 * User: Liu
 * Date: 2017/2/7
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Setting;
use App\Models\Admin\Links;
use App\Models\Admin\Book;
use App\Http\Controllers\Admin\UploadController;

use Validator;
class SettingController extends BaseController
{
    protected $Setting;

    public function __construct()
    {
        parent::__construct();
        $this->Setting = new Setting();
    }

    /**
     * 首页
     * @return mixed
     */
    public function getIndex()
    {
        $lists = $this->Setting->lists();
        $data = [
            'lists' => $lists
        ];
        return admin_view('setting.index',$data);
    }

    /**
     * 首页批量编辑
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex(Request $request)
    {
        $data = $request->data;
        $result = $this->Setting->update_setting($data);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'更新成功');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }


    /**
     * 创建新菜单项
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data , [
            'item'  => 'required',
            'name'  => 'required',
            'value' => 'required'
        ]);
        if($validator->fails())
        {
            $this->throwValidationException(
                $request,
                $validator
            );
        }
        $result = $this->Setting->create_setting($data);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'添加成功');
        }
        else
        {
            return back()->withErrors('添加失败')->withInput();
        }
    }


    /**
     * 单个删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(Request $request)
    {
        $result = $this->Setting->delete_setting($request->id);
        if($result)
        {
            return redirect()->route('Setting.getIndex')->with('Message' ,'删除成功');
        }
        else
        {
            return back()->withErrors('删除失败')->withInput();
        }
    }

    public function getCollect()
    {
        return 'test';
    }


    /**
     * 删除友情链接
     * @param Request $request
     * @param Links $links
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getFriendLinkDelete(Request $request, Links $links)
    {
        $result = $links->delete($request->id);
        if($result)
        {
            return redirect()->route('Setting.getFriendLinks')->with('Message' ,'删除成功');
        }
        else
        {
            return back()->withErrors('删除失败')->withInput();
        }
    }

    /**
     * 友情链接
     * @param Request $request
     * @param Links $links
     * @return mixed
     */
    public function getFriendLinks(Request $request, Links $links)
    {
        $lists = $links->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('setting.friendlinks',$data);
    }

    /**
     * 友情链接
     * @param Request $request
     * @param Links $links
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFriendLinks(Request $request, Links $links)
    {
        $data = $request->all();
        $data['status'] = 1;
        if(!empty($data['id'])){
            $links->update($data);
        }else{
            $links->create($data);
        }
        return redirect()->route('Setting.getFriendLinks')->with('Message' ,'操作成功');
    }

    /**
     * 图片上传到七牛
     * @param Request $request
     * @param Book $book
     * @param \App\Http\Controllers\Admin\UploadController $upload
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getImageUpload(Request $request, Book $book, UploadController $upload)
    {
        $lists = $book->where('thumb' ,'like' ,'%/uploads/%')->take(50)->get();
        $count = 0;
        foreach($lists as $v){
            $thumb = public_path() . $v->thumb;
            $file = uploadToQiniu($thumb);
            $v->thumb = $file;
            if($v->save()){
                $count++;
                \File::delete($thumb);
            }
        }
        return back()->with('Message' ,'成功上传 ' . $count . '张图片');
        //return admin_view('setting.imageupload',$data);
    }

    /**
     * 链接提交
     * @param Request $request
     * @return mixed
     */
    public function getLinkSubmit(Request $request)
    {
        if($request->has('site')){
            $site = $request->site;

            $number = $request->has('number') ? $request->number : 2000;

            $searchEngine = \DB::table('linksubmit')->where('site', $site)->first();

            $bookDetailLists = \DB::table('books_detail')->select('id','pid')->where('status',1)->where('id','>',$searchEngine['detailid'])->orderBy('id','ASC')->take($number)->get();

            if(empty($bookDetailLists)){
                return back()->with('Message' , '未发现待上传链接');
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

            $wapUrls = array_map(function($v){
                $v = str_replace(url() , env('APP_MOBILE_DOMAIN') , $v);
                return $v;
            } , $urls);

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
                    break;
                default:

                    break;
            }

            \DB::table('linksubmit')->where('site', $site)->update([
                'detailid'   => $detailID ,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->route('Setting.getLinkSubmit')->with('Message' , $message);
        }else{
            $lists = \DB::table('linksubmit')->get();
            $data = [
                'lists' => $lists,
            ];
            return admin_view('setting.linksubmit' , $data);
        }

    }
}