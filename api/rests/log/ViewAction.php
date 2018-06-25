<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\log;

use Yii;

/**
 * ViewAction implements the API endpoint for returning the detailed information about a model.
 *
 * For more details and usage information on ViewAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class ViewAction extends Action
{
    /**
     * Displays a model.
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being displayed
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->message = $message = unserialize($model->message);
        if (empty($message['userId'])) {
            $message['userId'] = '0';
        }
        $model->message = $message;

        $response = Yii::$app->response;
        $response->formatters = [
            yii\web\Response::FORMAT_JSON => [
                'class' => 'yii\web\JsonResponseFormatter',
                'encodeOptions' => 336,
            ],
            yii\web\Response::FORMAT_XML => [
                'class' => 'yii\web\XmlResponseFormatter',
            ],
        ];

        return ['code' => 10000, 'message' => Yii::t('success', '10802'), 'data' => $model];
    }
}
