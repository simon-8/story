<?php
/*
 * 简单的文章模块
 * */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\Article;
class ArticleController extends BaseController
{
    protected $Article;
	public function __construct()
    {
	    parent::__construct();
        $this->Article = new Article();
	}

    /**
     * 文章列表
     * @return mixed
     */
    public function getIndex()
    {
        $lists = $this->Article->lists();
		$data = [
		    'lists' => $lists,
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

        $result = $this->Article->create_article(array_merge($data , ['username' => self::$username]));
        if($result)
        {
            return redirect()->route('Article.getIndex');
        }
        else
        {
            return back()->withErrors('创建失败')->withInput();
        }
    }

    public function getUpdate($id)
    {
        $data = $this->Article->find($id);
        if(!$data){
            abort(404 , '文章不存在');
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
        $result = $this->Article->update_article($data);
        if($result)
        {
            return redirect()->route('Article.getIndex');
        }
        else
        {
            return back()->withErrors('更新失败')->withInput();
        }
    }


    public function getDelete()
    {

    }

    public function getCategorys()
    {

    }

    public function getRecycle()
    {

    }
}