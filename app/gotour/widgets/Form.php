<?php
namespace module\gotour\widgets;

class Form extends \yii\base\Widget
{
    public $listNo;

    public function run()
    {  
        return $this->render('form.phtml', ['listNo'=>$this->listNo]);
    }
}