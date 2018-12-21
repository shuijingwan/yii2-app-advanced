<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\page;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * DeleteAction implements the API endpoint for deleting a model.
 *
 * For more details and usage information on DeleteAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class DeleteAction extends Action
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        /* 判断状态，如果为删除，则返回失败 */
        if ($model->is_deleted === $model::IS_DELETED_YES) {
            return ['code' => 224007, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '224007'), ['id' => $id]))];
        }

        if ($model->softDelete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        return ['code' => 10000, 'message' => Yii::t('success', '124007')];
    }
}
