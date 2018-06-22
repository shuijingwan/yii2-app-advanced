<?php

namespace common\logics;

use Yii;
use yii\base\Model;

/**
 * LogSearch represents the model behind the search form about `common\models\Log`.
 */
class LogSearch extends Model
{
    public $level;
    public $category;
    public $log_time;
    public $prefix;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category', 'prefix'], 'trim'],
        ];
    }
}
