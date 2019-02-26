<?php
/**
 * 新华智云新闻报道网上传播分析系统数据上报功能
 * article plugin，保存文章时将上报加入队列
 * 需在本文件所在目录的config.php中增加
 * 'articlespm' => array('after_add', 'after_edit')
 * 制作：易木百宝，https://github.com/emoontb
 */
class plugin_articlespm extends object
{
    private $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function after_add()
    {
        $this->articlespm();
    }

    public function after_edit()
    {
        $this->articlespm();
    }

    private function articlespm()
    {
        if($this->article->data['status'] != 6) return; //状态不等于发布时跳出
        if(config('articlespm', 'catid')) {
            $catids = explode(',', $this->article->category[$this->article->data['catid']]['parentids']);
            array_push($catids, $this->article->data['catid']);
            if(!array_intersect($catids, config('articlespm', 'catid'))) return;
        }
        factory::queue('articlespm')->add($this->article->data); //数据加入队列
        return;
    }
}
