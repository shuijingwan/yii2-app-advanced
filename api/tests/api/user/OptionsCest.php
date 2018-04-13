<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class OptionsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    // 显示关于末端 /users 支持的动词(JSON响应)
    public function optionsIsJson(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendOPTIONS('/users');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        // 检查响应的数据
        $I->seeHttpHeader('Allow', 'GET, POST, HEAD, OPTIONS');
        $I->seeResponseEquals('');
    }

    // 显示关于末端 /users 支持的动词(XML响应)
    public function optionsIsXml(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendOPTIONS('/users');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        // 检查响应的数据
        $I->seeHttpHeader('Allow', 'GET, POST, HEAD, OPTIONS');
        $I->seeResponseEquals('');
    }

    // 显示关于末端 /users/{id} 支持的动词(JSON响应)
    public function optionsIdIsJson(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendOPTIONS('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        // 检查响应的数据
        $I->seeHttpHeader('Allow', 'GET, PUT, PATCH, DELETE, HEAD, OPTIONS');
        $I->seeResponseEquals('');
    }

    // 显示关于末端 /users/{id} 支持的动词(XML响应)
    public function optionsIdIsXml(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendOPTIONS('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        // 检查响应的数据
        $I->seeHttpHeader('Allow', 'GET, PUT, PATCH, DELETE, HEAD, OPTIONS');
        $I->seeResponseEquals('');
    }
}
