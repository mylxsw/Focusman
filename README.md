Focusman - 构建在SAE平台上的webdav服务
=====================

##安装说明

本程序需要上传到SAE，PHP版本选择5.6，同时，需要启用MySQL，KVDB支持，并且创建名称为`focusman`的Storage domain。

在上传程序之前，需要先初始化项目

    git clone https://github.com/mylxsw/Focusman.git
    cd Focusman
    composer update

> 本项目采用了composer进行依赖管理，因此需要先使用composer更新所有项目的依赖在上传到SAE。


