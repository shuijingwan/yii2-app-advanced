<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\user;

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

        /* 判断状态，如果为删除，则返回失败 */
        if ($model->status === $model::STATUS_DELETED) {
            return ['code' => 20003, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '20003'), ['id' => $id]))];
        }

        /* 判断状态，如果为禁用，则返回失败 */
        if ($model->status === $model::STATUS_DISABLED) {
            return ['code' => 20804, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '20804'), ['id' => $id]))];
        }

        return ['code' => 10000, 'message' => Yii::t('success', '10002'), 'data' => $model];
    }
}
