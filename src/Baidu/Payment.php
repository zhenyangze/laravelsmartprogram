<?php 
namespace yangze\LaravelSmartprogram\Baidu;

use BaiduMiniProgram\Payment\PaymentClient;

/**
 * 
 */
class Payment
{
    /**
     * 
     */
    protected $config = [];
    /**
     * 
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
        $this->app = new PaymentClient(
            array_get($this->config, 'deal_id'),
            array_get($this->config, 'app_key'),
            array_get($this->config, 'private_key'),
            array_get($this->config, 'public_key')
        );
    }

    /**
     * signForPolymerPayment 
     *
     * @param $orderId
     * @param $amount
     *
     * @return 
     */
    public function signForPolymerPayment($orderId, $amount = 0)
    {
        return $this->app->signForPolymerPayment();
    }

    /**
     * handleNotification 
     *
     * @param $successCall
     * @param $exceptionCall
     *
     * @return 
     */
    public function handleNotification($successCall, $exceptionCall)
    {
        return $this->app->handleNotification($successCall, $exceptionCall,request()->all());
    }
}
