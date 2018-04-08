<?php

namespace api\modules\v1\controllers;

/**
 * User controller for the `v1` module
 */
class UserController extends \api\controllers\UserController
{
    public $modelClass = 'api\modules\v1\models\User';
}
