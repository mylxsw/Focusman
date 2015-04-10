<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 14:40
 */

namespace Focusman\Sae;



class File extends \Sabre\DAV\File {

    /**
     * @var string 文件路径
     */
    private $_path;

    /**
     * 文件属性
     *
     * 'fileName', datetime', 'content_type', 'length', 'md5sum', 'expires'
     *
     * @var
     */
    private $_attr;

    /**
     * @var SaeStorage
     */
    private $_saeStorage;

    /**
     * 创建文件对象
     *
     * @param string     $path       文件路径
     * @param SaeStorage $saeStorage SAE STORAGE
     */
    public function __construct( $path) {
        $this->_path = $path;
        $this->_saeStorage = DI::getContainer()->get('saeStorage');
        $this->_attr = $this->_saeStorage->getAttr($this->_path);

    }

    /**
     * 删除当前文件
     *
     * @return bool
     */
    function delete() {
        return $this->_saeStorage->delete($this->_path);
    }

    /**
     * 获取当前文件名称
     *
     * This is used to generate the url.
     *
     * @return string
     */
    function getName() {
        return basename($this->_path);
    }

    /**
     * 文件重命名
     *
     * @param string $name The new name
     *
     * @return void
     */
    function setName( $name ) {
        // 如果名称不变，则不修改
        if (basename($this->_path) == $name) {
            return ;
        }

        $base_dir = dirname($this->_path);
        $this->_path =
            $this->_saeStorage->rename($this->_path, $base_dir . '/' . $name);
    }

    /**
     * 文件最后修改时间，UNIX时间戳
     *
     * @return int
     */
    function getLastModified() {
        return $this->_attr['datetime'];
    }

    /**
     * 写入文件
     *
     * @param resource $data
     */
    function put( $data ) {

        $auth = DI::getContainer()->get('authentication');
        $totalSpace = $auth->getTotalSpace();
        $spaceLimit = $auth->getSpaceLimit();

        if ($totalSpace >= $spaceLimit) {
            throw new Forbidden("空间不足，无法创建文件");
        }

        return $this->_saeStorage->write($this->_path, $data);
    }

    /**
     * 读取文件
     *
     * @return mixed
     */
    function get() {
        return $this->_saeStorage->read($this->_path);
    }

    /**
     * 获取文件大小
     *
     * @return int
     */
    function getSize() {
        return $this->_attr['length'];
    }

    function getETag() {
        return '"' . $this->_attr['md5sum'] . '"';
    }

    /**
     * 获取文件的Content Type
     *
     * @return string
     */
    function getContentType() {
        return $this->_attr['content_type'];
    }
}