<?php
/**
 * 图片上传处理器
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 1:25
 */

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allowedExt = ["png", "jpg", "gif", 'jpeg'];

    /**
     * 上传图片
     *
     * @param $file  object  文件实例
     * @param $folder  string  存放的文件夹
     * @param $filePrefix  string  文件前缀
     * @return array|bool  上传成功返回数组，失败返回 false
     */
    public function save($file, $folder, $filePrefix)
    {
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folderName = "uploads/images/$folder/" . date("Ym/d", time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larablog/public/uploads/images/avatars/201709/21/
        $uploadPath = public_path() . '/' . $folderName;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $filePrefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if (! in_array($extension, $this->allowedExt)) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($uploadPath, $filename);

        return [
            'path' => config('app.url') . "/$folderName/$filename", // 带 url 的绝对路径
            'relativePath' => "/$folderName/$filename" // 不带 url 的相对路径
        ];
    }
}