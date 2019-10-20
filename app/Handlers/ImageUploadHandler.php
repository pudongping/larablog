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
use Intervention\Image\ImageManagerStatic as Image;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allowedExt = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
    ];

    /**
     * 上传图片
     *
     * @param $file  object  文件实例
     * @param $folder  string  存放的文件夹
     * @param $filePrefix  string  文件前缀
     * @param $fileInputName  string  需要上传的图片在 form 表单中 input 框的 name 名称
     * @param $maxWidth  int|boolean  需要裁剪的最大宽度|不裁剪
     * @return array|bool  上传成功返回数组，失败返回 false
     */
    public function save($file, $folder, $filePrefix, $fileInputName = 'avatar', $maxWidth = false)
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
        if (! in_array($extension, array_keys($this->allowedExt))) {
            return false;
        }

        // 检查文件的 mime 类型的合法性
        if (! $this->fetchFileMimeType($fileInputName)) return false;

        // 将图片移动到我们的目标存储路径中
        $file->move($uploadPath, $filename);

        // 如果限制了图片的宽度，就进行裁剪
        if ($maxWidth && 'gif' != $extension) {
            // 裁剪图片
            $this->reduceSize($uploadPath . '/' . $filename, $maxWidth);
        }

        return [
            'path' => config('app.url') . "/$folderName/$filename", // 带 url 的绝对路径
            'relativePath' => "/$folderName/$filename" // 不带 url 的相对路径
        ];
    }

    /**
     * 获取图片文件的 mime 类型
     *
     * @param string $fileName 需要上传的图片文件表单中的 name 名
     * @return bool
     */
    public function fetchFileMimeType(string $fileName)
    {
        $fileInfo = $_FILES[$fileName]; // 文件信息
        $fileTrueName = $fileInfo['name']; // 文件实际名称
        $fileType = $fileInfo['type']; // 文件类型
        $fileTmpName = $fileInfo['tmp_name']; // 文件临时存储位置
        $fileError = $fileInfo['error']; // 文件上传错误码
        $fileSize = $fileInfo['size']; // 文件实际大小

        if ($fileError) return false;

        $ext = explode('.', $fileTrueName);
        $ext = strtolower(end($ext)); // 获取文件后缀

        if (! in_array($ext, array_keys($this->allowedExt))) return false;

        // 判断上传文件的 mime 类型
        $fi = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fi->file($fileTmpName);

        if (! in_array($mimeType, array_values($this->allowedExt))) return false;

        return true;
    }

    /**
     * 以固定宽度对图片进行等比例裁剪
     *
     * @param $filePath  文件的磁盘物理路径
     * @param $maxWidth  需要裁剪的宽度
     */
    public function reduceSize($filePath, $maxWidth)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($filePath);

        // 进行大小调整的操作
        $image->resize(
            $maxWidth,
            null,
            function ($constraint) {
                // 设定宽度是 $maxWidth，高度等比例缩放
                $constraint->aspectRatio();
                // 防止裁图时图片尺寸变大
                $constraint->upsize();
            }
        );

        // 对图片修改后进行保存
        $image->save();
    }

}