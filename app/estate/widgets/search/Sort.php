<?php
namespace module\estate\widgets\search;

use module\estate\helpers\SearchUrl;

class Sort extends \yii\base\Widget 
{
    public $search = null;

    public function run()
    {  
        $options = [
            '1'=>'价格由高到低',
            '2'=>'价格由低到高',
            '3'=>'卧室由多到少',
            '4'=>'卧室由少到多'
        ];
        $map = [
            '1'=>'list_price DESC',
            '2'=>'list_price ASC',
            '3'=>'no_bedrooms DESC',
            '4'=>'no_bedrooms ASC'
        ];

        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            if (isset($map[$sort])) {
                $sortExpr = $map[$sort];
                $this->search->query->orderBy($sortExpr);
            }
        } else {
            $this->search->query->orderBy('list_date DESC');
        }

        return $this->render('sort.phtml', [
            'self'=>$this,
            'options'=>$options,
            'selectedValue'=>isset($_GET['sort']) ? $_GET['sort'] : null
        ]);  
    }

    public function createUrl($name, $value)
    {
        return SearchUrl::to($name, $value);
    }
}