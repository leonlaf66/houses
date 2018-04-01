<?php
namespace module\core\components\api;

use yii\httpclient\Response as HttpResponse;

class Response extends HttpResponse
{
    public function asData()
    {
        return $this->getData();
    }
}