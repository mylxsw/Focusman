<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 15:21
 */

namespace Focusman\Sae;


use Focusman\Storage;
use Sabre\DAV\Exception\Forbidden;

class SaeStorageProxy implements Storage {

    use CacheTrait;

    /**
     * @var SaeStorage
     */
    private $_saeStorage = null;

    /**
     * @var Authentication
     */
    private $_authentication = null;

    /**
     * @return SaeStorage
     */
    protected function getSaeStorage() {
        return $this->_saeStorage;
    }

    /**
     * @return Authentication
     * @throws \DI\NotFoundException
     */
    protected function getAuthentication() {
        return $this->_authentication;
    }

    public function __construct(SaeStorage $saeStorage, Authentication $auth) {
        $this->_saeStorage = $saeStorage;
        $this->_authentication = $auth;
    }

    /**
     * 文件是否存在
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function fileExists( $filename ) {
        if (!$this->getAuthentication()->checkPermission($filename)) {
            throw new Forbidden("禁止访问");
        }

        return $this->getSaeStorage()->fileExists($filename);
    }

    /**
     * 是否目录
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function isDirectory( $filename ) {
        if (!$this->getAuthentication()->checkPermission($filename)) {
            throw new Forbidden("禁止访问");
        }

        return $this->getSaeStorage()->isDirectory($filename);
    }

    /**
     * 删除文件
     *
     * @param string $filename filename
     *
     * @return bool
     */
    public function delete( $filename ) {
        if (!$this->getAuthentication()->checkPermission($filename)) {
            throw new Forbidden("禁止访问");
        }

        $res = $this->getSaeStorage()->delete($filename);
        $this->cacheDel(
            Tools::getUserTotalSpaceKey(
                $this->getAuthentication()->getCurrentUser()));
        return $res;
    }

    /**
     * 获取文件属性
     *
     * @param string $filename filename
     *
     * @return array ['fileName', datetime', 'content_type', 'length', 'md5sum', 'expires']
     */
    public function getAttr( $filename ) {
        if (!$this->getAuthentication()->checkPermission($filename)) {
            throw new Forbidden("禁止访问");
        }

        return $this->getSaeStorage()->getAttr($filename);
    }

    /**
     * 获取目录下子文件（文件夹）
     *
     * @param string $path file path
     *
     * @return array [[name:basename, fullName:pathname]...]
     */
    public function getListByPath( $path ) {
        if (!$this->getAuthentication()->checkPermission($path)) {
            throw new Forbidden("禁止访问");
        }

//        return $this->cacheGet(
//            Tools::getUserListByPathKey(
//                $this->getAuthentication()->getCurrentUser(),
//                $path
//            ),
//            function () use ($path) {
        return $this->getSaeStorage()->getListByPath($path);
//            }
//        );
    }

    /**
     * 获取路径下所有文件列表（扁平目录结构）
     *
     * @param string $path path
     *
     * @return string[] 文件名列表
     */
    public function getList( $path ) {
        if (!$this->getAuthentication()->checkPermission($path)) {
            throw new Forbidden("禁止访问");
        }

//        return $this->cacheGet(
//            Tools::getUserListKey($this->getAuthentication()->getCurrentUser(), $path),
//            function () use ($path) {
        return $this->getSaeStorage()->getList($path);
//            }
//        );
    }

    /**
     * 读取文件内容
     *
     * @param string $path path
     *
     * @return string
     */
    public function read( $path ) {
        if (!$this->getAuthentication()->checkPermission($path)) {
            throw new Forbidden("禁止访问");
        }

        return $this->getSaeStorage()->read($path);
    }

    /**
     * 写入文件
     *
     * @param string $path path
     * @param string $data data
     *
     * @return bool
     */
    public function write( $path, $data ) {
        if (!$this->getAuthentication()->checkPermission($path)) {
            throw new Forbidden("禁止访问");
        }

        $res = $this->getSaeStorage()->write($path, $data);

        $this->cacheDel(
            Tools::getUserTotalSpaceKey(
                $this->getAuthentication()->getCurrentUser()));

        return $res;
    }

    /**
     * 创建目录
     *
     * @param string $dirname dirname
     *
     * @return bool
     */
    public function makeDirectory( $dirname ) {
        if (!$this->getAuthentication()->checkPermission($dirname)) {
            throw new Forbidden("禁止访问");
        }

        $res = $this->getSaeStorage()->makeDirectory($dirname);
        $this->cacheDel(
            Tools::getUserTotalSpaceKey(
                $this->getAuthentication()->getCurrentUser()));

        return $res;
    }

    /**
     * 重命名文件
     *
     * @param string $source source path
     * @param string $dest destination path
     *
     * @return bool
     */
    public function rename( $source, $dest ) {
        if (!$this->getAuthentication()->checkPermission($source)) {
            throw new Forbidden("禁止访问");
        }

        if (!$this->getAuthentication()->checkPermission($dest)) {
            throw new Forbidden("禁止访问");
        }

        return $this->getSaeStorage()->rename($source, $dest);
    }
}