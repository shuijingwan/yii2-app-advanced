<?php

namespace common\logics;

use Yii;
use yii\base\Model;

/**
 * PageSearch represents the model behind the search form about `common\models\Page`.
 */
class PageSearch extends Model
{
    public $title;
    public $slug;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['title', 'slug'], 'string'],
            [['title', 'slug'], 'trim'],
        ];
    }
}
