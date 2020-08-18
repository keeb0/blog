<?php

namespace app\assets;

use yii\web\AssetBundle;

class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/bootstrap.min.css',
	    'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
	    'css/jquery.bxslider.css',
	    'css/style.css',
    ];
    public $js = [
		// 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
		'js/bootstrap.min.js',
		'js/jquery.bxslider.js',
		'js/mooz.scripts.min.js',
    ];
    public $depends = [
    ];
}
