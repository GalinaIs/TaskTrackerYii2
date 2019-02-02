<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TasksAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/tasks.css',
    ];
    public $js = [
    ];
}
