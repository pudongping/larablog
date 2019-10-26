<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-25
 * Time: 17:19
 */

namespace App\Repositories\Admin\Menu;

use App\Repositories\BaseRepository;
use App\Models\Admin\Menu\Menu;

class MenusRepository extends BaseRepository
{

    protected $model;

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    /**
     * 菜单树形结构
     *
     * @return array
     */
    public function menusTree()
    {
        $menus = $this->all()->toArray();
        $data = $this->tree($menus);
        return $data;
    }

    /**
     * 指定父级、指定层级，得到菜单树形结构
     *
     * @param array  $menus  菜单列表 一维数组
     * @param int $root  父级标识，这里默认 0 为父级
     * @param int $level  需要得到多少层树形结构
     * @return array  树形结构
     */
    private static function tree($menus, $root = 0, $level = 100): array
    {
        $data = [];
        foreach ($menus as $menu) {
            if ($menu['pid'] == $root) {
                if ($level > 0) {
                    $menu['children'] = static::tree($menus, $menu['id'], $level - 1);
                }
                $data[] = $menu;
            }
        }
        --$level;
        return $data;
    }

}
