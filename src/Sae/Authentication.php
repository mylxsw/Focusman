<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 18:11
 */

namespace Focusman\Sae;


use Sabre\DAV\Auth\Backend\AbstractBasic;

/**
 * Class Authentication
 * @package Focusman\Sae
 */
class Authentication extends AbstractBasic {

    use CacheTrait;

    private $_user;

    /**
     * @return Repo\UserRepo
     * @throws \DI\NotFoundException
     */
    protected function getUserRepo() {
        return DI::getContainer()->get('userRepo');
    }

    /**
     * Validates a username and password
     *
     * This method should return true or false depending on if login
     * succeeded.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    protected function validateUserPass( $username, $password ) {

        $user = $this->getUserRepo()->getUser($username);

        if (!empty($user) && $user['password'] == sha1($password)) {
            $this->_user = $user;
            return true;
        }

        return false;
    }

    /**
     * 检查用户对目录是否有权限
     *
     * @param string $path 要检查的目录
     *
     * @return bool
     */
    public function checkPermission($path) {

        $prefix = $this->getCurrentUser() . '/';
        if (strncmp($prefix, rtrim($path, '/') . '/', strlen($prefix)) == 0) {
            return true;
        }

        return false;
    }

    /**
     * 获取用户空间限制
     *
     * @return int 单位byte
     */
    public function getSpaceLimit() {
        return $this->_user['spacelimit'];
    }

    /**
     * 获取用户当前使用的空间总量
     *
     * @return int
     * @throws \DI\NotFoundException
     */
    public function getTotalSpace() {
        return $this->cacheGet(
            Tools::getUserTotalSpaceKey($this->getCurrentUser()),
            function () {
                $total_size = 0;

                $storage = DI::getContainer()->get('saeStorage');
                $files = $storage->getList($this->getCurrentUser());
                foreach ($files as $file) {
                    $attr = $storage->getAttr($file);
                    $total_size += $attr['length'];
                }

                return $total_size;
            }
        );
    }
}