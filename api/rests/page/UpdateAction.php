<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\page;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

/**
 * UpdateAction implements the API endpoint for updating a model.
 *
 * For more details and usage information on UpdateAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class UpdateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the model before it is validated and updated.
     */
    public $scenario = Model::SCENARIO_DEFAULT;


    /**
     * Updates an existing model.
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being updated
     * @throws ServerErrorHttpException if there is any error when updating the model
     */
    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        /* 判断状态，如果为删除，则返回失败 */
        if ($model->is_deleted === $model::IS_DELETED_YES) {
            return ['code' => 224007, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '224007'), ['id' => $id]))];
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false) {
            if ($model->hasErrors()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(422, 'Data Validation Failed.');
                foreach ($model->getFirstErrors() as $message) {
                    $firstErrors = $message;
                    break;
                }
                return ['code' => 226004, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '226004'), ['firstErrors' => $firstErrors]))];
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }

        return ['code' => 10000, 'message' => Yii::t('success', '124006'), 'data' => $model];
    }
}
