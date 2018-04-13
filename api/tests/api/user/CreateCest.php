<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class CreateCest
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

    // 创建用户(创建用户成功、JSON响应)
    public function createIsJson(ApiTester $I)
    {
        $data = [
            'username' => '111111',
            'email' => '111111@163.com',
            'password' => '111111',
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED); // 201
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        $I->seeResponseJsonMatchesJsonPath('$.data');
        $I->seeResponseJsonMatchesJsonPath('$.data.username');
        $I->seeResponseJsonMatchesJsonPath('$.data.email');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 10000,
            'message' => Yii::t('success', '10003'),
            'data' => [
                'username' => $data['username'],
                'email' => $data['email'],
            ],
        ]);
    }

    // 创建用户(创建用户成功、XML响应)
    public function createIsXml(ApiTester $I)
    {
        $data = [
            'username' => '111111',
            'email' => '111111@163.com',
            'password' => '111111',
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED); // 201
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        $I->seeXmlResponseMatchesXpath('//data');
        $I->seeXmlResponseMatchesXpath('//data//username');
        $I->seeXmlResponseMatchesXpath('//data//email');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 10000]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('success', '10003')]));
        $I->seeXmlResponseIncludes(Xml::toXml(['username' => $data['username']]));
        $I->seeXmlResponseIncludes(Xml::toXml(['email' => $data['email']]));
    }

    // 创建用户，使用空的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function createWithEmptyFieldsIsJson(ApiTester $I)
    {
        $data = [];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Username cannot be blank.']);
    }

    // 创建用户，使用空的字段值(数据验证失败：{firstErrors}、XML响应)
    public function createWithEmptyFieldsIsXml(ApiTester $I)
    {
        $data = [];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Username cannot be blank.']));
    }

    // 创建用户，使用错误的邮箱(数据验证失败：{firstErrors}、JSON响应)
    public function createWithWrongEmailIsJson(ApiTester $I)
    {
        $data = [
            'username' => '111111',
            'email' => '111111',
            'password' => '111111',
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Email is not a valid email address.']);
    }

    // 创建用户，使用错误的邮箱(数据验证失败：{firstErrors}、XML响应)
    public function createWithWrongEmailIsXml(ApiTester $I)
    {
        $data = [
            'username' => '111111',
            'email' => '111111',
            'password' => '111111',
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Email is not a valid email address.']));
    }

    // 创建用户，使用已经存在的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function createWithExistFieldsIsJson(ApiTester $I)
    {
        $data = [
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Username "troy.becker" has already been taken.']);
    }

    // 创建用户，使用已经存在的字段值(数据验证失败：{firstErrors}、XML响应)
    public function createWithExistFieldsIsXml(ApiTester $I)
    {
        $data = [
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPOST('/users', $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Username "troy.becker" has already been taken.']));
    }
}
