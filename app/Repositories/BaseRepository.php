<?php
/**
 * 数据资源仓库抽象类
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/15
 * Time: 23:48
 */

namespace App\Repositories;
use App\Support\TempValue;


abstract class BaseRepository
{

    protected $model;

    /**
     * 取出指定数据或者全部数据
     *
     * @param null $where 条件语句
     * @return mixed 数据集
     */
    public function all($where = null)
    {
        $model = $this->model;
        if (!empty($where)) {
            $model = $this->model->where($where);
        }
        return $model->get();
    }

    /**
     * 使用分页
     *
     * @param $model 模型实例
     * @param string $sortColumn 排序字段
     * @param string $sort 排序规则 desc|asc
     * @return mixed 数据集
     */
    protected function usePage($model, $sortColumn = 'id', $sort = 'desc')
    {
        $number = TempValue::$perPage > 0 ? TempValue::$perPage : \ConstCustom::PAGE_NUM;

        if (!empty(TempValue::$orderBy)) {
            // 支持 TempValue::$orderBy = id,desc|name,asc
            $order = explode('|', TempValue::$orderBy);
            foreach ($order as $value) {
                if (!empty($value)) {
                    list($sortColumn, $sort) = explode(',', $value);
                    $model = $model->orderBy($sortColumn, $sort);
                }
            }
        } elseif ($sortColumn && $sort) {
            if (is_array($sortColumn) && is_array($sort)) {
                // 支持 $sortColumn = ['id','name'] , $sort = ['desc','asc']
                foreach ($sortColumn as $k => $col) {
                    $rank = array_key_exists($k,$sort) ? $sort[$k] : 'desc';
                    $model = $model->orderBy($col, $rank);
                }
            } else {
                $model = $model->orderBy($sortColumn, $sort);
            }
        }

        return TempValue::$nopage ? $model->get() : $model->paginate($number);
    }

    /**
     * 分页记录集
     *
     * @param null $where 条件语句
     * @return mixed 数据集
     */
    public function page($where = null)
    {
        $model = $this->model;
        if (!empty($where)) {
            $model = $this->model->where($where);
        }
        return $this->usePage($model);
    }

    /**
     * 生成开始时间和结束时间的搜索条件
     *
     * @param $request 请求实例
     * @param null $defaultBegin 默认开始时间
     * @param null $defaultEnd 默认结束时间
     * @return array|bool 开始时间结束时间数组
     */
    public function searchTime($request, $defaultBegin = null, $defaultEnd = null)
    {
        $begin = $request->input('begin', $defaultBegin);
        if (!empty($begin) && empty($defaultEnd)) {
            $defaultEnd = date('Y-m-d H:i:s');
        }
        $end = $request->input('end', $defaultEnd);
        if (!strtotime($begin) && !strtotime($end)) {
            return false;
        }
        return [$begin, $end];
    }

    /**
     * 保存数据
     *
     * @param $input ["column" => "value"] 关联数组
     * @return mixed
     */
    public function store($input)
    {
        $this->model->fill($input);
        $this->model->save();
        return $this->model;
    }

    /**
     * 更新一条记录
     *
     * @param $id 记录 id
     * @param $input ["column" => "value"] 关联数组
     * @return mixed
     */
    public function update($id, $input)
    {
        $this->model = $this->getById($id);
        $this->model->fill($input);
        $this->model->save();
        return $this->model;
    }

    /**
     * 通过主键检索一个模型
     *
     * @param $id 数据主键
     * @param bool $isFail 是否开启「未找到」异常
     * @return mixed
     */
    public function getById($id, $isFail = true)
    {
        if ($isFail) {
            return $this->model->findOrFail($id);
        } else {
            return $this->model->find($id);
        }
    }

    /**
     * 检索查询的第一个结果
     *
     * @param $value 检索值
     * @param string $column 字段名
     * @param bool $isFail 是否开启「未找到」异常
     * @return mixed
     */
    public function getSingleRecord($value, $column = 'id', $isFail = true)
    {
        $model = $this->model->where($column, $value);
        if ($isFail) {
            return $model->firstOrFail();
        } else {
            return $model->first();
        }
    }


    /**
     * 删除一条记录
     *
     * @param $id
     * @return mixed
     */
    public function del($id)
    {
        $this->model = $this->getById($id);
        $this->model->delete();
        return $this->model;
    }

}