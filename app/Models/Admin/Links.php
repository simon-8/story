<?php
/**
 * Note: 友情链接
 * User: Liu
 * Date: 2017/3/31
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
class Links extends Model
{
    protected $fillable = [
        'title',
        'linkurl',
        'listorder',
        'status',
    ];
}