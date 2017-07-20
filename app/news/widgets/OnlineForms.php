<?php
namespace module\news\widgets;

class OnlineForms extends \yii\base\Widget
{
    public function run()
    {
        $items = [
            /*
            [
                'title'=>'CONTRACT TO PURCHASE REAL ESTATE#501',
                'info'=>'CONTRACT TO PURCHASE REAL ESTATE#501',
                'file'=>'501-2.pdf'
            ],*/
            /*
            [
                'title'=>'EXCLUSIVE RIGHT TO SELL LISTING AGREEMENT',
                'info'=>'EXCLUSIVE RIGHT TO SELL LISTING AGREEMENT',
                'file'=>'707+-+Exclusive+Right+to+Sell+Listing+Agr.+(With+Consent+to+Dual+Agency)+-+2010.pdf'
            ],*/
            [
                'title'=>'MASSACHUSETTS MANDATORY LICENSEE-CONSUMER RELATIONSHIP DISCLOSURE',
                'info'=>'This disclosure is provided to you, the consumer, by the real estate agent listed on this form. Make sure you read both sides of this
form. The reverse side contains a more detailed description of the different types of relationships available to you. This is not a
contract.',
                'file'=>'disclosure_form_agency_non_agency.pdf'
            ],
            /*
            [
                'title'=>'EXCLUSIVE BUYER AGENCY AGREEMENT',
                'info'=>'EXCLUSIVE BUYER AGENCY AGREEMENT',
                'file'=>'Exclusive-Buyer-agency-agreement-ma.pdf'
            ],*/
            [
                'title'=>'PROPERTY TRANSFER NOTIFICATION CERTIFICATION',
                'info'=>'This form is to be signed by the prospective purchaser before signing a purchase and sale agreement or a memorandum
of agreement, or by the lessee-prospective purchaser before signing a lease with an option to purchase for residential
property built before 1978, for compliance with federal and Massachusetts lead-based paint disclosure requirements.',
                'file'=>'lead-form-blank.pdf'
            ]
        ];

        return $this->render('online-forms.phtml', [
            'items'=>$items
        ]);
    }
}