<?php
namespace module\news\widgets;

class TopBanner extends \yii\base\Widget
{
    public function run()
    {
        $result = [
            'main' => [
                'title'=>'莫尔登投资回报率 8% 的公寓，牛顿市不到 $80 万的独栋',
                'image'=>media_url('news/banners/main.jpg'),
                'height'=>'240px',
                'url'=>'http://www.baidu.com'
            ],
            'childrens' => [
                [
                    'title'=>'莫尔登投资回报率 8% 的公寓，牛顿市不到 $80 万的独栋',
                    'image'=>media_url('news/banners/children1.jpg'),
                    'url'=>'http://www.baidu.com'
                ],
                [
                    'title'=>'麻州好学区介绍（二） | 牛顿市 美丽的“花园”学区',
                    'image'=>media_url('news/banners/children2.jpg'),
                    'url'=>'http://www.baidu.com'
                ],
                [
                    'title'=>'韦尔斯利市 Wellesley | 高中好，大学也好，你咋不上天呢？！',
                    'image'=>media_url('news/banners/children3.jpg'),
                    'url'=>'http://www.baidu.com'
                ],
            ]
        ];

        return $this->render('top-banners.phtml', [
            'result'=>$result
        ]);
    }
}