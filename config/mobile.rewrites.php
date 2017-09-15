<?php
return [
    /*
    'home/default/area' => function ($req) {
        return '/area.html';
    },
    'home/default/index' => function ($req) {
        return '/';
    },
    'estate/house/purchase' => function ($req) {
        return '/purchase.html';
    },
    'estate/house/lease' => function ($req) {
        return '/lease.html';
    },*/
    'estate/house/purchase/view' => function ($req) {
        return ['/home.html', 'id' => $req->get('id')];
    },
    'estate/house/lease/view' => function ($req) {
        return ['/home.html', 'id' => $req->get('id')];
    },
    /*
    'schooldistrict/default/index' => function ($req) {
        
    },
    'schooldistrict/default/view' => function ($req) {
        
    },
    'yellowpage/default/index' => function ($req) {
        
    },
    'yellowpage/search/result' => function ($req) {
        
    },
    'yellowpage/default/view' => function ($req) {
        
    },
    'news/default/index' => function ($req) {
        
    },
    'news/default/view' => function ($req) {
        
    }*/
];