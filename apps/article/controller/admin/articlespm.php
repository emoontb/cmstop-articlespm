<?php
/**
 * 新华智云新闻报道网上传播分析系统数据上报功能
 * 计划任务执行文件
 * 需在系统计划任务中添加
 * app=article&controller=articlespm&action=cron
 * 制作：易木百宝，https://github.com/emoontb
 */
class controller_admin_articlespm extends article_controller_abstract
{
    function __construct($app)
    {
        parent::__construct($app);
    }

    function cron()
    {
        @set_time_limit(600);

        $queue = factory::queue('articlespm');
        $interval_size = config('articlespm', 'interval_size', 10);

        $json = array(
            'state' => true,
            'info' => $queue->interval($interval_size),
        );
        exit ($this->json->encode($json));
    }
}