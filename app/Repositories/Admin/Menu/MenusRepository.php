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
        $data = $this->tree($menus, 0, 1);
        return $data;
    }

    /**
     * 指定父级、指定层级，得到菜单树形结构
     *
     * @param array  $menus  菜单列表 一维数组
     * @param int $root  父级标识，这里默认 0 为父级
     * @param int $level  需要得到多少层树形结构 （得到二维数组为 0，得到三维数组为 1）
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

    /**
     * 菜单列表
     *
     * @param $request  请求实例
     * @return array  一维数组
     */
    public function getList($request)
    {
        $search = $request->search;

        $model = $this->model->where(function ($query) use ($search) {
            if (! empty($search)) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('link', 'like', '%' . $search . '%');
            }
        });

        // 分页实例
        $paginator = $this->usePage($model, ['sort', 'id'], ['desc', 'asc']);

        // 分页后的数据
        $currentMenus = $paginator->getCollection()->toArray();
        // 将菜单按照一定的父子关系进行排列
        $menus = $this->regroup($currentMenus);
        // 将没有父子级别的数组和有父子级别的数组进行合并
        $menus = $this->compareDiff($currentMenus, $menus);

        // 因为分页会自动追加 page 参数，因此需要先去除掉 page 参数，然后将其他的参数追加到 url 中
        $pageLinks = $paginator->appends($request->except('page'))->links();

        return compact('menus', 'pageLinks');
    }

    /**
     * 获取具有父子关系的一维数组
     *
     * @param $menus  所有的菜单数据
     * @param int $root  指定顶级父级别 id
     * @param array $result  返回的一维数组
     * @return array
     */
    public function regroup($menus, $root = 0, &$result = []) : array
    {
        foreach ($menus as $menu) {
            // 排除掉非直接子集
            if ($root != $menu['pid']) {
                continue;
            }
            $result[$menu['id']] = $menu;  // 第一次执行的时候，只会将 pid 为 0 的值写进数组
            $this->regroup($menus, $menu['id'], $result);
        }

        return $result;
    }

    /**
     * 比较并补齐没有父子级别的菜单数据
     *
     * @param array $compared  被比较的数组 （完整的菜单数组）
     * @param array $comparing  比较的数组  （具有父子级别的数组）
     * @return array  具有 「父子级别的数组靠前、没有父子级别的数组靠后」 的合并数组  （完整的菜单数组）
     */
    public function compareDiff(array $compared, array $comparing) : array
    {
        if (empty($compared)) return $compared;

        // 没有 「不具有父子级别的数组」 时，直接返回
        if (count($compared) == count($comparing)) return $comparing;

        foreach ($compared as $item) {
            if (! isset($comparing[$item['id']])) {
                // 将没有父子级别的数组添加到具有父子级别的数组后
                $comparing[$item['id']] = $item;
            }
        }

        return $comparing;
    }

}
