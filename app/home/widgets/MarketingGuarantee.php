<?php
namespace module\home\widgets;

class MarketingGuarantee extends \yii\base\Widget
{
    public function run()
    {  
        $items = [
            'market'=>[
                'en-US'=>[
                    'heading'=>'Knowing The Marketing',
                    'info'=>'Experts review, professional comments, real-time data sharing, customer experience sharing.'
                ],
                'zh-CN'=>[
                    'heading'=>'市场 早知道',
                    'info'=>'房市热点冰点? 租金是涨是跌? 存量是放是缩? 专家点评, 专业分享, 实时数据, 一手分享'
                ]
            ],
            'select'=>[
                'en-US'=>[
                    'heading'=>'Decision Helper',
                    'info'=>'Looking for rental properties? Our SMART SEARCH helps you locate right property!'
                ],
                'zh-CN'=>[
                    'heading'=>'选房 帮你搜',
                    'info'=>'租在哪里? 买在何地? 智能搜索, 省时省力的高性能选择'
                ]
            ],
            'manage'=>[
                'en-US'=>[
                    'heading'=>'Take Care Your Home',
                    'info'=>'Whenever and wherever you are, we have house maintenance solution for you.'
                ],
                'zh-CN'=>[
                    'heading'=>'管房 有渠道',
                    'info'=>'春夏秋冬, 房产的维护和保养管家中心资源共享'
                ]
            ],
            'service'=>[
                'en-US'=>[
                    'heading'=>'24/7 Customer Service',
                    'info'=>'Always available for your personal service needs.'
                ],
                'zh-CN'=>[
                    'heading'=>'客服 全天候',
                    'info'=>'24小时在线答疑, 件件有回复'
                ]
            ],
        ];

        return $this->render('marketing-guarantee.phtml', ['items'=>$items]);  
    }
}