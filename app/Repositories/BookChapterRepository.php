<?php
/**
 * Note: 章节资源库
 * User: Liu
 * Date: 2018/4/12
 */

namespace App\Repositories;

use App\Models\Admin\BookDetail;

class BookChapterRepository extends BaseRepository
{
    public function __construct(BookDetail $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $condition
     * @param string $order
     * @param int $pagesize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lists($condition = [], $order = 'id DSEC', $pagesize = 20)
    {
        $fields = ['id', 'pid', 'chapterid', 'title', 'created_at', 'updated_at'];
        $order = $order ? explode(' ', $order) : ['id', 'DESC'];
        return $this->model->select($fields)
                    ->where(array_merge(['status' => 1], $condition))
                    ->orderBy($order[0], $order[1])
                    ->paginate($pagesize);
    }

    /**
     * @param $pid
     * @return string
     */
    protected function getContentPath($pid)
    {
        return public_path("uploads/content/{$pid}/");
    }

    /**
     * @param $pid
     * @param $chapterid
     * @return string
     */
    public function getContent($pid, $chapterid)
    {
        $bookDir = $this->getContentPath($pid);
        try {
            return \File::get($bookDir . "{$chapterid}.txt");
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $pid
     * @param $chapterid
     * @param $content
     * @return int
     */
    function setContent($pid, $chapterid, $content)
    {
        $bookDir = $this->getContentPath($pid);
        if (!\File::isDirectory($bookDir)) {
            \File::makeDirectory($bookDir, 0777, true);
        }
        return \File::put($bookDir . "{$chapterid}.txt" , $content);
    }

    /**
     * 删除内容文本
     * @param $pid
     * @param $chapterid
     * @return bool
     */
    function deleteContent($pid, $chapterid)
    {
        $bookDir = $this->getContentPath($pid);
        $path = $bookDir . "{$chapterid}.txt";

        if (\File::exists($path)) {
            return \File::delete($path);
        }
        return false;
    }

    public function updateDetail($data)
    {
        $item = $this->find($data['id']);
        if (!$item) return false;
        $item->title = $data['title'];
        $item->status = $data['status'];
        return $item->save();
    }

    /**
     * @param $pid
     * @param $aid
     * @return mixed|static
     */
    public function nextPage($pid, $aid)
    {
        return $this->model->select('id')
                ->where('pid', $pid)
                ->where('id', '>', $aid)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->first();
    }

    /**
     * @param $pid
     * @param $aid
     * @return mixed|static
     */
    public function prevPage($pid, $aid)
    {
        return $this->model->select('id')
                ->where('pid', $pid)
                ->where('id', '<', $aid)
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->first();
    }

    /**
     * @param $pid
     * @return mixed|static
     */
    public function lastDetail($pid)
    {
        return $this->model->select('id', 'title')
                ->where('pid', $pid)
                ->where('status', 1)
                ->orderBy('chapterid', 'DESC')
                ->first();
    }
}