<?php

namespace App\Http\Controllers\Home;

use App\Repositories\BookRepository;
use App\Repositories\LinkRepository;


class IndexController extends BaseController
{
    public function getIndex(BookRepository $bookRepository, LinkRepository $linkRepository)
    {
        $categorys = $bookRepository->getCategorys();

        //最近更新
        $newLists = \Cache::remember('newLists', 60, function () use ($bookRepository, $categorys) {
            $newLists = $bookRepository->lists([], 'updated_at desc', 50, false);
            if (count($newLists)) {
                $newLists = $this->setCatname($newLists->toArray(), $categorys);
            }
            return $newLists;
        });
        //最新入库
        $newInserts = \Cache::remember('newInsert', 60, function () use ($bookRepository, $categorys) {
            $newInserts = $bookRepository->lists([], 'id desc', 50, false);
            if (count($newInserts)) {
                $newInserts = $this->setCatname($newInserts->toArray(), $categorys);
            }
            return $newInserts;
        });

        //各分类推荐
        $tjLists = \Cache::remember('tjLists', 600, function () use ($categorys, $bookRepository) {
            $tjLists = [];
            $i = 1;
            foreach ($categorys as $k => $v) {
                if ($k == 9) break;
                $tjLists[$i]['catname'] = $v['name'];
                $tjLists[$i]['id'] = $k;
                $tjLists[$i]['data'] = $bookRepository->lists(['catid' => $k], '', 7, false)->toArray();
                $i++;
            }
            return $tjLists;
        });

        //封面推荐
        $ftLists = \Cache::remember('ftLists', 600, function () use ($bookRepository) {
            return $bookRepository->ftlists([], 'hits DESC', 6)->toArray();
        });

        //firendLinks
        $firendLinks = \Cache::remember('firendLinks', 600, function () use ($linkRepository) {
            return $linkRepository->lists();
        });

        $data = [
            'newLists' => $newLists,
            'newInserts' => $newInserts,
            'tjLists' => $tjLists,
            'ftLists' => $ftLists,
            'firendLinks' => $firendLinks
        ];
        return home_view('index.index', $data);
    }

    /**
     *
     * @param $data
     * @param $categorys
     * @return array
     */
    protected function setCatname($data, $categorys)
    {
        $new_data = [];
        foreach ($data as $v) {
            $v['catname'] = $categorys[$v['catid']]['name'];
            $new_data[] = $v;
        }
        return $new_data;
    }
}