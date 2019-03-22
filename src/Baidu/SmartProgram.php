<?php 
namespace yangze\LaravelSmartprogram\Baidu;

use BaiduMiniProgram\BaiduClient;
use BaiduMiniProgram\Services\BaiduTemplate;
use BaiduMiniProgram\Services\BaiduTemplateMessage;
use yangze\LaravelSmartprogram\Lib\RequestLib;

/**
 * 
 */
class SmartProgram
{
    /**
     *  $config
     */
    protected $config = [];
    /**
     *  $app
     */
    protected $app;
    /**
     * __construct 
     *
     * @param $config
     *
     * @return 
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->app = new BaiduClient(
            array_get($this->config, 'app_key'),
            array_get($this->config, 'app_secret')
        );
    }

    /**
     * session 
     *
     * @param $code
     *
     * @return 
     * {
     *  "openid": "ABCDEFG123",
     *  "session_key": "xxxxxx"
     * }
     */
    public function session(String $code) 
    {
        return $this->app->session($code);
    }

    /**
     * decrypt 
     *
     * @param $data
     * @param $iv
     * @param $sessionKey
     *
     * @return 
     */
    public function decrypt($data, $iv, $sessionKey)
    {
        return $this->app->decrypt($data, $iv, $sessionKey);
    }

    /**
     * function 
     *
     * @param $templateId
     * @param $keyArr
     * @param $swanId
     * @param $sceneId
     * @param $sceneType  场景类型，1：表单，2：百度收银台订单
     *
     * @return 
     */
    public function template($templateId, $keyArr = [], $link = null, $swanId = '', $sceneId = '', $sceneType = 1)
    {
        //$template = new BaiduTemplate($this->app->serviceClient());
        $serviceClient = $this->app->serviceClient();
        return (new BaiduTemplateMessage($templateId, $serviceClient))
            ->withKeywords($keyArr)
            ->withPage($link)
            ->sendTo($swanId, $sceneId, $sceneType);
    }

    public function templateManager()
    {
        $serviceClient = $this->app->serviceClient();
        return new BaiduTemplate($serviceClient);
    }
}
