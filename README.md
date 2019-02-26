# 思拓内容管理系统媒体版-新华智云新闻报道网上传播分析系统数据上报功能

### 本插件适用于思拓内容管理系统媒体版，调试于CmsTop Media 1.9.0.10756，不保证其他版本能否正常使用

## 概述
根据新华智云《新闻报道网上传播分析系统埋点对接手册》，新闻网站需要调用API上传新闻网站的稿件内容，本插件通过扩展思拓的模型插件、队列引擎、计划任务等3个功能实现该功能，未修改任何系统文件，仅在插件配置文件中添加一行记录，不影响编辑保存文章时的速度

## 实现流程
在文章模型增加插件，将编辑保存的文章录入到思拓的队列，为队列增加上报引擎，通过计划任务定时触发引擎上报

## 文件介绍
### config/articlespm.php
配置文件，用于设置媒体机构ID、站点名称、AccessKey、secretKey、需要上报的栏目ID和每次上报多少条记录

### apps/article/plugin/model_admin_article/articlespm.php
保存文章时将上报加入队列，使用本文件需在本文件所在目录的config.php中增加一行：'articlespm' => array('after_add', 'after_edit')

### apps/article/controller/admin/articlespm.php
计划任务执行文件，使用本文件需要在系统计划任务中添加：app=article&controller=articlespm&action=cron

### framework/queue/engine/articlespm.php
队列引擎，用于执行上报队列

## 使用方法
* 将所有文件按目录上传至cmstop服务器
* 修改config/articlespm.php，进行相关参数设置
* 修改apps/article/plugin/model_admin_article/config.php，增加一行：'articlespm' => array('after_add', 'after_edit')
* 在后台计划任务中添加计划任务，参数分别为：app=article&controller=articlespm&action=cron

![计划任务](https://github.com/emoontb/uploaded-files/blob/master/cmstop-articlespm/20190225171754_001.png)

## 调试方法
* 添加文章后，观察数据库中cmstop_queue表是否有数据增加
* 执行计划任务，观察计划任务结果

![计划任务结果](https://github.com/emoontb/uploaded-files/blob/master/cmstop-articlespm/20190225172813_002.png)
