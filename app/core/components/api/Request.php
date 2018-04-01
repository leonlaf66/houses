<?php
namespace module\core\components\api;

use yii\httpclient\Request as HttpRequest;

class Request extends HttpRequest
{
    public $apiToken = '';
    protected $params = [];

    public function setParams($params = [])
    {
        $this->params = $params;
        return $this;
    }

    public function addParams($params = [])
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function sendAndReturnJson($assoc = true)
    {
        $response = $this->send();
        return json_decode($response->content, $assoc);
    }

    public function beforeSend()
    {
        $this->addParams([
            'app_token' => $this->apiToken,
            'language' => \yii::$app->language,
            'area_id' => \yii::$app->area->id
        ]);

        if (!\WS::$app->user->isGuest) {
            $this->addParam('access_token', \WS::$app->user->identity->access_token);
        }

        $method = strtoupper($this->getMethod());
        if ($method === 'POST') {
            $url = $this->getUrl();
            $url .= '?' . http_build_query($this->params);
            $this->setUrl($url);
        } elseif ($method === 'GET') {
            $data = $this->getData() ?? [];
            $data = array_merge($data, $this->params);
            $this->setData($data);
        }

        parent::beforeSend();
    }
}