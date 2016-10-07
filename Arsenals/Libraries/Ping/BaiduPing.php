<?php

namespace Arsenals\Libraries\Ping;

/**
 * 百度ping服务
 */
class BaiduPing
{
    /**
     * @var string
     */
    private $_ping_url = 'http://ping.baidu.com/ping/RPC2';
    /**
     * @var string
     */
    private $_host = 'ping.baidu.com';
    /**
     * @var string
     */
    private $_xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<methodCall>
    <methodName>weblogUpdates.extendedPing</methodName>
    <params>
        <param>
            <value><string>[[_VAR_SITE_NAME_]]</string></value>
        </param>
        <param>
            <value><string>[[_VAR_SITE_URL_]]</string></value>
        </param>
        <param>
            <value><string>[[_VAR_BLOG_URL_]]</string></value>
        </param>
        <param>
            <value><string>[[_VAR_RSS_]]</string></value>
        </param>
    </params>
</methodCall>
XML;

    /**
     * 构造函数，完成BaiduPing的初始化.
     */
    public function __construct($config = [])
    {
    }

    /**
     * 执行ping操作.
     *
     * @param $site_name
     * @param $site_url
     * @param $blog_url
     * @param $rss
     *
     * @return mixed
     */
    public function ping($site_name, $site_url, $blog_url, $rss)
    {
        $xml = trim(preg_replace([
            '#\[\[_VAR_SITE_NAME_\]\]#',
            '#\[\[_VAR_SITE_URL_\]\]#',
            '#\[\[_VAR_BLOG_URL_\]\]#',
            '#\[\[_VAR_RSS_\]\]#',
        ], [
            $site_name,
            $site_url,
            $blog_url,
            $rss,
        ], $this->_xml));

        $ch = curl_init();
        $headers = [
            'Content-Type: text/xml;charset="utf-8"',
            'Accept: text/xml',
        ];

        curl_setopt($ch, CURLOPT_URL, $this->_ping_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $result = curl_exec($ch);

        return strpos($result, '<int>0</int>') ? true : false;
    }
}
