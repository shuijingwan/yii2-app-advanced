<?php

namespace common\behaviors;

use wartron\yii2uuid\helpers\Uuid;

class UUIDBehavior extends \wartron\yii2uuid\behaviors\UUIDBehavior
{
    public function createUUID()
    {
        return Uuid::uuid2str(parent::createUUID());
    }

}