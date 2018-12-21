<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\page;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * CreateAction implements the API endpoint for creating a new model from the given data.
 *
 * For more details and usage information on CreateAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class CreateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string the name of the view action. This property is need to create the URL when the model is successfully created.
     */
    public $viewAction = 'view';

    public $createScenario = 'create';


    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->createScenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        // 模型转换成数组
        $data = $model->attributes;

        // 内容协商
        $response = Yii::$app->response;
        $acceptParams = $response->acceptParams;
        if (isset($acceptParams['version'])) {
            $version = $acceptParams['version'];
        } else {
            $version = '';
        }

        if ($model->validate()) {
            $data = $model->create($data, $version, Yii::$app->language);
            if ($data['code'] === 10000) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = $data['data']['id'];
                $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            }
            return $data;
        } elseif ($model->hasErrors()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422, 'Data Validation Failed.');
            foreach ($model->getFirstErrors() as $message) {
                $firstErrors = $message;
                break;
            }
            return ['code' => 226004, 'message' => Yii::t('error', Yii::t('error', Yii::t('error', '226004'), ['firstErrors' => $firstErrors]))];
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}
