<?php
/**
 * 返回码
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-16
 * Time: 10:12
 */

namespace App\Support;

class Code
{

    /**
     * 正常时,返回码
     */
    const SUCC = 0;

    /**
     * http 相关错误
     */
    const ERR_HTTP_UNAUTHORIZED = 401;
    const ERR_HTTP_FORBIDDEN = 403;
    const ERR_HTTP_NOT_FOUND = 404;
    const ERR_INTERNAL_SERVER = 500;

    /**
     * 1000 系统级别错误
     */
    const ERR_QUERY = 1001;
    const ERR_DB = 1002;
    const ERR_PARAMS = 1003;
    const ERR_MODEL = 1004;
    const ERR_FILE_UP_LOAD = 1005;
    const ERR_COMPANY_NAME = 1006;
    const ERR_PERM = 1007;
    const ERR_EXCEL_COLUMN = 1008;

    /**
     * 10000 系统设置
     */
    const ERR_MENU_FIELD = 10001;
    const ERR_EXPORT = 10002;
    const ERR_QRCODE = 10003;


    public static $msgs = [
        self::SUCC => '操作成功',

        self::ERR_HTTP_UNAUTHORIZED => '登录已过期，请重新登录',
        self::ERR_HTTP_FORBIDDEN => '无权访问该地址',
        self::ERR_HTTP_NOT_FOUND => '请求地址不存在',
        self::ERR_INTERNAL_SERVER => '服务器内部错误',

        self::ERR_QUERY => '数据库操作失败',
        self::ERR_DB => '数据库连接失败',
        self::ERR_PARAMS => '参数验证失败： %s',
        self::ERR_MODEL => '数据不存在',
        self::ERR_FILE_UP_LOAD => '文件上传出错',
        self::ERR_COMPANY_NAME => '错误的公司名称',
        self::ERR_PERM => '没有该操作权限，请联系管理员',
        self::ERR_EXCEL_COLUMN => 'Excel文件列数异常',

        self::ERR_MENU_FIELD => '该菜单存在子菜单，无法删除',
        self::ERR_EXPORT => '导出文件失败，请联系管理员',
        self::ERR_QRCODE => '二维码生成错误',
    ];

    /**
     * 提示代码
     * @var | int
     */
    protected static $code;

    /**
     * 提示信息
     * @var | string
     */
    protected static $msg;

    /**
     * 详情信息
     * @var
     */
    protected static $detail;

    /**
     * 设置提示信息
     *
     * @param $code 提示代码
     * @param null $msg 提示信息
     * @param array $params 提示信息中动态参数
     */
    public static function setCode($code, $msg = null, $params = [])
    {
        self::$code = $code = (int)$code;
        if (null == $msg) {
            if (isset(self::$msgs[$code])) {
                if (!empty($params)) {
                    array_unshift($params, self::$msgs[$code]);
                    self::$msg = call_user_func_array('sprintf', $params);
                } else {
                    self::$msg = self::$msgs[$code];
                }
            } else {
                self::$msg = '提示信息未定义';
            }
        } else {
            self::$msg = $msg;
        }

        if (self::SUCC !== $code) {
            // save log
        }

    }

    /**
     * 获取提示信息，带错误码
     *
     * @return array 提示代码，提示信息
     */
    public static function getCode()
    {
        if (is_null(self::$code)) {
            self::setCode(self::SUCC);
        }
        return [self::$code, self::$msg];
    }

    /**
     * 获取提示信息，不带错误码
     *
     * @return mixed
     */
    public static function getErrMsg()
    {
        return self::$msg;
    }

    /**
     * 设置详细信息
     *
     * @param $detail
     */
    public static function setDetail($detail)
    {
        self::$detail = $detail;
    }

    /**
     * 获取详细信息
     *
     * @return mixed
     */
    public static function getDetail()
    {
        return self::$detail;
    }

}
