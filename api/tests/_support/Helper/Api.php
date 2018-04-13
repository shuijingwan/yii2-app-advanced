<?php
namespace api\tests\Helper;

use Yii;
use yii\helpers\StringHelper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{

    // 获取当前版本号(次版本号.修订号)
    public function getMinorPatch() {
        $version = StringHelper::explode(Yii::$app->version, '.');
        return $version[1] . '.' . $version[2];
    }

}
