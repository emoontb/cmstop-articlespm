<?php
/**
 * 新华智云新闻报道网上传播分析系统数据上报功能
 * 配置文件
 * 制作：易木百宝，https://github.com/emoontb
 */
return array (
    'unitId' => '', //媒体机构ID
    'site' => '', //站点名
    'accessKey' => '',
    'secretKey' => '',
    'catid' => array(1), //需要上报的栏目ID，该栏目及子栏目的文章将被上报，如果需要全站上报请删除本行
    'interval_size' => 10, // 每次上报多少记录
    //'queue_max_times' => 3 // 每条记录最多执行次数，因思拓队列系统设计问题，该设置由mail.php控制
);
