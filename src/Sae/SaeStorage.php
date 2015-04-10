<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 14:41
 */

namespace Focusman\Sae;


use Focusman\Storage;

class SaeStorage implements Storage {

    private $_sae;
    private $_domain = 'focusman';

    public function __construct() {
        $this->_sae = new \SaeStorage();
    }

    public function fileExists( $filename ) {

        // 文件存在，直接返回
        if ($this->_sae->fileExists($this->_domain, $filename)) {
            return true;
        }

        // 文件不存在，猜测可能是单目录
        if ($this->_sae->fileExists($this->_domain, rtrim($filename, '/') . '/.placeholder')) {
            return true;
        }

        // 如果目录中不包含.placeholder文件，则检测是否目录中含有文件
        $list = $this->getListByPath($filename);
        if (empty($list)) {
            return false;
        }

        return true;
    }

    public function isDirectory($filename) {
        $basename = basename($filename);
        // 如果是目录占位符，则是目录
        if ($basename == '.placeholder') {
            return true;
        }

        // 如果文件存在，则不是目录
        if ($this->_sae->fileExists($this->_domain, $filename)) {
            return false;
        }

        // 文件不存在，猜测可能是单目录
        if ($this->_sae->fileExists($this->_domain, rtrim($filename, '/') . '/.placeholder')) {
            return true;
        }

        // 如果目录中不包含.placeholder文件，则检测是否目录中含有文件
        $list = $this->getListByPath($filename);
        if (!empty($list)) {
            return true;
        }

        return false;
    }

    public function delete( $filename ) {
        return $this->_sae->delete($this->_domain, $filename);
    }

    /**
     * @param $filename
     *
     * @return array ['fileName', datetime', 'content_type', 'length', 'md5sum', 'expires']
     */
    public function getAttr($filename) {
        return $this->_sae->getAttr($this->_domain, $filename);
    }

    public function getListByPath($path) {

        $result = [];

        $num = 0;
        while ($res = $this->_sae->getListByPath($this->_domain, trim($path, '/'), 100, $num)) {
            if (isset($res['dirs'])) {
                $result = array_merge($result, $res['dirs']);
            }

            if (isset($res['files'])) {
                $result = array_merge($result, $res['files']);
            }
            $num = $num + 100;
        }


        $result = array_map(
            function ($value) {

                if (isset($value['Name'])) {
                    $value['name'] = $value['Name'];
                    unset($value['Name']);
                }

                return $value;
            },
            $result
        );

        return $result;
    }

    public function getList($path) {
        $result = [];

        $num = 0;
        while ($ret = $this->_sae->getList($this->_domain, $path, 100, $num)) {
            foreach ($ret as $file) {
                $result[] = $file;
            }

            $num = $num + 100;
        }
        return $result;
    }

    public function read($path) {
        return $this->_sae->read($this->_domain, $path);
    }

    public function write($path, $data) {
        return $this->_sae->write($this->_domain, $path, $data);
    }

    public function makeDirectory($dirname) {
        return $this->write(rtrim($dirname, '/') . '/.placeholder', null);
    }

    public function rename($source, $dest) {
        // 读取文件数据，写入新文件，删除旧文件，更新路径
        $content = $this->read($source);
        $this->write($dest, $content);
        $this->delete($source);
        return $dest;
    }
}