<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/11/17
 * Time: 14:54
 */

namespace App\Repositories\Admin\Setting;


class SitesRepository
{

    /**
     * 站点相关数据
     *
     * @var array
     */
    protected $data = [
        'name' => '',
        'contact_email' => '',
        'seo_description' => '',
        'seo_keyword' => '',
    ];

    /**
     * 编辑站点设置
     *
     * @return array
     */
    public function edit()
    {
        return $this->populateData($this->data);
    }

    /**
     * 更新站点设置数据
     *
     * @param $request
     */
    public function update($request)
    {
        $data = $request->only(['name', 'contact_email', 'seo_description', 'seo_keyword']);

        $path = $this->getStoragePath();
        $file = $path . \ConstCustom::SITE_FILE_NAME;

        // 如果存在之前的文件则直接删除
        if (file_exists($file)) unlink($file);

        // 检查存储路径是否可写
        if (!is_writable($path)) {
            throw new \InvalidArgumentException('「' . $file . '」' . '文件不可写');
        }

        // 写入文件中
        file_put_contents($file, json_encode($data));

    }

    /**
     * 获取站点设置数据保存文件硬盘绝对路径
     *
     * @return string
     */
    private function getStoragePath()
    {
        return storage_path() . '/' . \ConstCustom::SITE_PATH . '/';
    }

    /**
     * 如果能够找到设置文件，则填充数据数组
     *
     * @param array $data
     * @return array
     */
    public function populateData(array $data)
    {
        $path = $this->getStoragePath();

        // 如果存储路径不存在，请尝试创建该存储路径
        if (!is_dir($path)) mkdir($path);

        $file = $path . \ConstCustom::SITE_FILE_NAME;

        if (file_exists($file)) {
            // 获取文件中的数据
            $fileData = json_decode(file_get_contents($file));

            foreach ($fileData as $filed => $value) {
                // 用文件中的数据替换掉默认数据
                if (array_key_exists($filed, $data)) {
                    $data[$filed] = $value;
                }
            }

        }

        return $data;

    }

}
