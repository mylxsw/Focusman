<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 22:40
 */

namespace Focusman\Sae;


use Sabre\DAV\DAV;

/**
 * Class HomeCollection
 * @package Focusman\Sae
 */
class HomeCollection extends Directory {

    /**
     * Returns an array with all the child nodes
     *
     * @return \Sabre\DAV\INode[]
     */
    function getChildren() {
        $home = new Directory($this->getPath());
        return $home->getChildren();
    }

    /**
     * Returns the name of the node.
     *
     * This is used to generate the url.
     *
     * @return string
     */
    function getName() {
        return 'home';
    }

    /**
     * 获取用户主目录
     *
     * 如果没有用户主目录，则自动创建
     *
     * @return string
     * @throws \DI\NotFoundException
     */
    protected function getPath() {
        if (empty($this->_path)) {
            $user = DI::getContainer()->get('authentication')->getCurrentUser();

            $saeStorage = DI::getContainer()->get('_saeStorage');
            if (!$saeStorage->fileExists($user)) {
                $saeStorage->makeDirectory($user);
            }

            $this->_path = $user;
        }

        return $this->_path;
    }


}