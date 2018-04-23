<?php
/**
 * Note: 小说模型
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'catid',
        'title',
        'introduce',
        'thumb',
        'zhangjie',
        'author',
        'wordcount',
        'level',
        'follow',
        'hits',
        'status',
        'source',
        'fromurl',
        'fromhash',
    ];
}