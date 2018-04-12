<?php
/**
 * Note: *
 * User: Liu
 * Date: 2017/3/13
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $table = 'books_detail';
    protected $fillable = [
        'pid',
        'chapterid',
        'title',
        //'content',
        'hits',
        'status',
        'fromurl',
        'fromhash',
    ];
}