<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
	public function __construct(){

	}

	public function getIndex(){

		$data = [];
		return admin_view('article.index',$data);
	}
	public function getCreate()
    {

    }
    public function postCreate()
    {

    }
    public function getUpdate()
    {

    }
    public function postUpdate()
    {

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