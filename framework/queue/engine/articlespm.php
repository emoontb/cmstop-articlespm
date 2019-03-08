<?php
/**
 * 新华智云新闻报道网上传播分析系统数据上报功能
 * 队列引擎
 * 制作：易木百宝，https://github.com/emoontb
 */
class queue_articlespm extends queue_engine
{
    function execute(array $params)
    {

        $get = array(
            'access_key' => config('articlespm', 'accessKey'),
            'timestamp' => intval(microtime(true)*1000),
        );
        $get['signature'] = md5(config('articlespm', 'secretKey') . $get['timestamp'] . $get['access_key']);
        $url = 'https://api.wts.xinwen.cn/newspaper/manual-up?' . http_build_query($get);

        $keywords = array(); //处理关键词
        foreach($params['keywords'] as $keyword) {
            $keywords[] = $keyword['tag'];
        }

        $specialchars = array('&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&fnof;','&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;','&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;','&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&Prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;','&OElig;','&oelig;','&Scaron;','&scaron;','&Yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&Dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;');
        $entities = array(' ','¡','¢','£','¤','¥','¦','§','¨','©','ª','«','¬','­','®','¯','°','±','²','³','´','µ','¶','·','¸','¹','º','»','¼','½','¾','¿','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','×','Ø','Ù','Ú','Û','Ü','Ý','Þ','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','÷','ø','ù','ú','û','ü','ý','þ','ÿ','ƒ','Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω','α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ','ς','σ','τ','υ','φ','χ','ψ','ω','ϑ','ϒ','ϖ','•','…','′','″','‾','⁄','℘','ℑ','ℜ','™','ℵ','←','↑','→','↓','↔','↵','⇐','⇑','⇒','⇓','⇔','∀','∂','∃','∅','∇','∈','∉','∋','∏','∑','−','∗','√','∝','∞','∠','∧','∨','∩','∪','∫','∴','∼','≅','≈','≠','≡','≤','≥','⊂','⊃','⊄','⊆','⊇','⊕','⊗','⊥','⋅','⌈','⌉','⌊','⌋','⟨','⟩','◊','♠','♣','♥','♦','Œ','œ','Š','š','Ÿ','ˆ','˜',' ',' ',' ','‌','‍','‎','‏','–','—','‘','’','‚','“','”','„','†','‡','‰','‹','›','€');
        $newsIntro = str_replace($specialchars, $entities, htmlspecialchars_decode(strip_tags($params['content']), ENT_QUOTES)); //处理正文

        //处理配图
        $pattern = '/<img\s+[^>]*src\s*=\s*(["\']?)([^>"\']+)\1[^>]*[\/]?>/im';
        preg_match_all($pattern, $params['content'], $matches);
        $newsImages = $matches[2];

        $post = array(
            'id' => '无', //必填，报和号外id，若不是报纸请填"无"
            'unitId' => config('articlespm', 'unitId'), //必填，媒体机构编号，联系@齐萌获取
            'targetId' => $params['contentid'], //必填，稿件ID（和埋点的targetID保持一致）
            'num' => '无', //必填，总版次
            'articleType' => '无', //必填，文章类型
            'sourceUrl' => $params['url'], //必填，源url，同一家媒体机构如果重复上传同一个url（"无"除外），会覆盖之前版本
            'isFrontPage' => 'false', //必填，是否头版
            'site' => config('articlespm', 'site'), //站点名
            'pubTime' => $params['published']*1000, //必填，出版时间（时间戳，单位毫秒）
            'isTransfer' => 'false', //必填，是否转版
            'language' => 'zh', //必填，语种，符合ISO 639-1 规范，参考
            'title' => strip_tags($params['title']), //必填，标题
            'subTitle' => strip_tags($params['subtitle']), //子标题
            'lead' => $params['description'], //导语
            'keywords' => implode(',', $keywords), //关键词，多个关键词用逗号分隔
            'author' => ($params['author']?:'无'), //必填，作者
            'newsIntro' => $newsIntro, //必填，正文
            'content' => $params['content'], //必填，正文（带html标签）
            'hasImages' => (count($newsImages)>0?'true':'false'), //必填，是否配图
            'newsImages' => $newsImages, //配图链接，数组传递
            'contentWordsCount' => words_count($newsIntro), //字数统计
            'isNewsRelease' => 'false', //必填，是否通稿
            'isExtra' => 'false', //必填，是否号外
        );
        $post = preg_replace('/newsImages%5B\d+%5D/', 'newsImages', http_build_query($post));//因新华智云API对数组处理与http_build_query不同，手动修复
        $request = request($url, $post, NULL, NULL, array('CURLOPT_HTTPHEADER' => array('Content-type: application/x-www-form-urlencoded')));
        if($request['httpcode'] != 200) {
            $this->_error = $request['httpcode'];
            return false;
        }
        $result = decodeData($request['content']);
        if($result['code'] != 0) {
            $this->_error = $request['content'];
            return false;
        }
        return true;
    }
}
