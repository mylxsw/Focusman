<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 15:37
 */

namespace Focusman;


interface Storage {
    /**
     * 文件是否存在
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function fileExists( $filename );

    /**
     * 是否目录
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function isDirectory($filename);

    /**
     * 删除文件
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function delete( $filename );

    /**
     * 获取文件属性
     *
     * @param string $filename filename
     *
     * @return array ['fileName', datetime', 'content_type', 'length', 'md5sum', 'expires']
     */
    public function getAttr($filename);

    /**
     * 获取目录下子文件（文件夹）
     *
     * @param string $path file path
     *
     * @return array [[name:basename, fullName:pathname]...]
     */
    public function getListByPath($path);

    /**
     * 获取路径下所有文件列表（扁平目录结构）
     *
     * @param string $path path
     *
     * @return string[] 文件名列表
     */
    public function getList($path);

    /**
     * 读取文件内容
     *
     * @param string $path path
     *
     * @return string
     */
    public function read($path);

    /**
     * 写入文件
     *
     * @param string $path path
     * @param string $data data
     *
     * @return bool
     */
    public function write($path, $data);

    /**
     * 创建目录
     *
     * @param string $dirname dirname
     *
     * @return bool
     */
    public function makeDirectory($dirname);

    /**
     * 重命名文件
     *
     * @param string $source source path
     * @param string $dest   destination path
     *
     * @return bool
     */
    public function rename($source, $dest);
}