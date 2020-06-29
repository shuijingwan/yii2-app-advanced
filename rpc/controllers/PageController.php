<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2018/08/01
 * Time: 15:01
 */

namespace rpc\controllers;

use Yii;
use rpc\models\Page;
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
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionCreate(array $data, string $version = '', string $language = '')
    {
        if (!empty($language)) {
            Yii::$app->language = $language;
        }

        /* @var $model Page */
        $model = new $this->modelClass([
            'scenario' => $this->createScenario,
        ]);

        if ($model->load($data, '') && $model->save()) {
            $data = $model->attributes;
        } elseif ($model->hasErrors()) {
            $firstError = '';
            foreach ($model->getFirstErrors() as $message) {
                $firstError = $message;
                break;
            }
            return ['code' => 232004, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '232004'), ['first_error' => $firstError]))];
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return ['code' => 10000, 'message' => Yii::t('success', '130005'), 'data' => $data];
    }
}