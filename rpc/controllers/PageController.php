<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/08/01
 * Time: 15:01
 */

namespace rpc\controllers;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Page Controller
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class PageController extends ServerController
{
    public $createScenario = 'create';

    /**
     * 创建页面
     *
     * @param array $data 数据
     *
     * @param string $version 版本号(次版本号与修订号)
     * 格式如下：
     * 2.3
     *
     * @param string $language 区域和语言
     * 格式如下：
     * en-US
     *
     * @return mixed
     */
    public function actionCreate(array $data, string $version = '', string $language = '')
    {
        if (!empty($language)) {
            Yii::$app->language = $language;
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->createScenario,
        ]);

        if ($model->load($data, '') && $model->save()) {
            $data = $model->attributes;
        } elseif ($model->hasErrors()) {
            foreach ($model->getFirstErrors() as $message) {
                $firstErrors = $message;
                break;
            }
            return ['code' => 232004, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '232004'), ['firstErrors' => $firstErrors]))];
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason1.');
        }

        return ['code' => 10000, 'message' => Yii::t('success', '130005'), 'data' => $data];
    }
}