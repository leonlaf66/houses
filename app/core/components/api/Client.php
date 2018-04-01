<?php
namespace module\core\components\api;

use yii\httpclient\Client as HttpClient;

class Client extends HttpClient
{
    public $appToken = '';

    public function create($url, $method = 'get')
    {
        return $this->createRequest()
            ->setUrl($url)
            ->setMethod($method);
    }
}