<?php
/*
 * 简单的文章模块
 * */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\Article;
use App\Models\Admin\Tag;
class ArticleController extends BaseController
{
    protected $Article;
    protected $Tag;
	public function __construct()
    {
	    parent::__construct();
        $this->Article = new Article();
        $this->Tag = new Tag();
	}

    /**
     * 文章列表
     * @return mixed
     */
    public function getIndex(Request $request)
    {
        $status = $request->has('status') ? $request->status : 1;

        $lists = $this->Article->lists(['status' => $status]);
        $tags = $this->Tag->lists();
        $status_num = $this->Article->get_status_num();

		$data = [
		    'lists' => $lists,
            'tags'  => $tags,
            'status_num' => $status_num,
        ];
		return admin_view('article.index',$data);
	}

    /**
     * 创建文章
     * @return mixed
     */
    public function getCreate()
    {
        $data = [];
        return admin_view('article.create' , $data);
    }

    /**
     * 创建校验
     * @param $data
     * @return mixed
     */
    protected function validate_create($data)
    {
        return Validator::make($data , [
            'title' => 'required|string',
            'content' => 'required|string',
            'catid' => 'required|numeric',
        ]);
    }

    /**
     * 创建文章
     * @param Request $request
     * @param AuthController $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();

        $validator = $this->validate_create($data);
        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $result = $this->Article->create_article(array_merge($data , ['username' => self::$username]));

        $this->Tag->create_tag($data['tag'],$data['id']);

        if($result)
        {
            return redirect()->route('Article.getIndex');
        }
        else
        {
            return back()->withErrors('创建失败')->withInput();
        }
    }

    /**
     * 更新用户
     * @param $id
     * @return mixed
     */
    public function getUpdate($id)
    {
        $data = $this->Article->find($id);
        if(!$data){
            abort(404 , '文章不存在');
        }
        if($data['tag']){
            $data['tag_lists'] = explode(',',$data['tag']);
            $data['tag'] .= ',';
        }else{
            $data['tag_lists'] = [];
        }
        return admin_view('article.create' , $data);
    }


    /**
     * 更新用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        $data = $request->all();
        $validator = $this->validate_create($data);

        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request , $validator
            );
        }
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $result = $this->Article->update_article($data);

        $this->Tag->create_tag($data['tag'],$data['id']);

        if($result)
        {
            return redirect()->route('Article.getIndex');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }


    /**
     * 删除文章
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(Request $request)
    {
        $article = $this->Article->find($request->id);
        if($article)
        {
            $result = $article->delete();
            if($result)
            {
                return redirect()->route('Article.getIndex')->with('Message' , '删除成功');
            }
            else
            {
                return redirect()->route('Article.getIndex')->withErrors('删除失败');
            }
        }
        else
        {
            return redirect()->route('Article.getIndex')->withErrors('文章不存在');
        }
    }

    public function getCategorys()
    {

    }

    /**
     * 移动到回收站
     * @param Request $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function getRecycle(Request $request)
    {
        $article = $this->Article->find($request->id);
        if($article)
        {
            $result = $article->recycle();
            if($result)
            {
                return redirect()->route('Article.getIndex')->with('Message' , '删除到回收站成功');
            }
            else
            {
                return redirect()->route('Article.getIndex')->withErrors('删除失败');
            }
        }
        else
        {
            return redirect()->route('Article.getIndex')->withErrors('文章不存在');
        }
    }
}