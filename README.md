# 第一个聊天房间

#### 介绍
我的第一个聊天房间，基于php js html swoole实现的

#### 软件架构
软件架构说明


#### 安装教程

第一种方法：需要服务器，安装lamp环境以及swoole，把全部代码置入其中

第二种方法：开启虚拟机linux，安装lamp环境以及swoole，把websocket.php放进去，再开启本地的PHP环境，运行index.html

#### 使用说明

1. config

    chat.sql 数据库
    
    config.php 本地配置定义
    
    doAction.fun.php 封装登陆注册等方法
    
    mysql.fun.php 数据库增删改查代码的封装
    
    page.fun.php 分页封装
    
    upload.fun.php 上传代码封装

2. css

    页面样式
3. images

    头像、样式等图片集合
4. js

   common.js 实现ajax跳转
   
   tabs.js 实现聊天房间的显示、隐藏，以及websocket的主要功能
5. doAction.php 

   前端与后端的连接桥梁
6. include.php 
   
   包含文件
7. websocket.php swoole
   
   实现websocket的主要方法
8. index.html 

   首页，登陆
9. home.php  
   
   主页面，聊天页面

#### 参与贡献

1. Fork 本仓库
2. 新建 Feat_xxx 分支
3. 提交代码
4. 新建 Pull Request


#### 码云特技

1. 使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2. 码云官方博客 [blog.gitee.com](https://blog.gitee.com)
3. 你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解码云上的优秀开源项目
4. [GVP](https://gitee.com/gvp) 全称是码云最有价值开源项目，是码云综合评定出的优秀开源项目
5. 码云官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6. 码云封面人物是一档用来展示码云会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)