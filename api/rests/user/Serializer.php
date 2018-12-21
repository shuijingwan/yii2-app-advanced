<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rests\user;

use Yii;
use yii\data\DataProviderInterface;

/**
 * Serializer converts resource objects and collections into array representation.
 *
 * Serializer is mainly used by REST controllers to convert different objects into array representation
 * so that they can be further turned into different formats, such as JSON, XML, by response formatters.
 *
 * The default implementation handles resources as [[Model]] objects and collections as objects
 * implementing [[DataProviderInterface]]. You may override [[serialize()]] to handle more types.
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class Serializer extends \yii\rest\Serializer
{
    /**
     * Serializes a data provider.
     * @param DataProviderInterface $dataProvider
     * @return array the array representation of the data provider.
     */
    protected function serializeDataProvider($dataProvider)
    {
        if ($this->preserveKeys) {
            $models = $dataProvider->getModels();
        } else {
            $models = array_values($dataProvider->getModels());
        }
        $models = $this->serializeModels($models);

        if (($pagination = $dataProvider->getPagination()) !== false) {
            $this->addPaginationHeaders($pagination);
        }

        if ($this->request->getIsHead()) {
            return null;
        } elseif ($this->collectionEnvelope === null) {
            return $models;
        }

        $result = [
            $this->collectionEnvelope => $models,
        ];

        if (empty($result['items'])) {
            return ['code' => 226001, 'message' => Yii::t('error', '226001')];
        }

        if ($pagination !== false) {
            return ['code' => 10000, 'message' => Yii::t('success', '126001'), 'data' => array_merge($result, $this->serializePagination($pagination))];
        }

        return ['code' => 10000, 'message' => Yii::t('success', '126001'), 'data' => $result];
    }
}
