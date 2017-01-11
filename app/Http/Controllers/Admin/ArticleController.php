<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ArticleController extends Controller
{
	public function __construct(){

	}
	public function getIndex(){

		$data = [];
		return admin_view('article.index',$data);
	}
}