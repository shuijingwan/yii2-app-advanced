<?php

namespace common\logics\rpc;

use Yii;

/**
 * 页面模型
 */
class Page extends Model
{
    const STATUS_DELETED = -1; //状态：删除
    const STATUS_DISABLED = 0; //状态：禁用
    const STATUS_DRAFT = 1; //状态：草稿
    const STATUS_PUBLISHED = 2; //状态：发布

    const CONTROLLER_ID = 'page'; //控制器ID

    const SCENARIO_CREATE = 'create';

    public $slug;
    public $title;
    public $body;
    public $view;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['slug', 'title', 'body', 'view', 'status'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['view', 'status'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'slug' => Yii::t('model/rpc/page', 'Slug'),
            'title' => Yii::t('model/rpc/page', 'Title'),
            'body' => Yii::t('model/rpc/page', 'Body'),
            'view' => Yii::t('model/rpc/page', 'View'),
            'status' => Yii::t('model/rpc/page', 'Status'),
        ];
    }

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
     */
    public function create(array $data, string $version, string $language)
    {
        $actionId = 'create';
        return self::client(self::CONTROLLER_ID, $actionId)->$actionId($data, $version, $language);
    }

}