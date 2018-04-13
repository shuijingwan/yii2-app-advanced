<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class UpdateCest
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

    // 更新用户(更新用户成功、JSON响应)
    public function updateIsJson(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        $I->seeResponseJsonMatchesJsonPath('$.data');
        $I->seeResponseJsonMatchesJsonPath('$.data.email');
        $I->seeResponseJsonMatchesJsonPath('$.data.status');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 10000,
            'message' => Yii::t('success', '10004'),
            'data' => [
                'email' => $data['email'],
                'status' => $data['status'],
            ],
        ]);
    }

    // 更新用户(更新用户成功、XML响应)
    public function updateIsXml(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        $I->seeXmlResponseMatchesXpath('//data');
        $I->seeXmlResponseMatchesXpath('//data//email');
        $I->seeXmlResponseMatchesXpath('//data//status');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 10000]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('success', '10004')]));
        $I->seeXmlResponseIncludes(Xml::toXml(['email' => $data['email']]));
        $I->seeXmlResponseIncludes(Xml::toXml(['status' => $data['status']]));
    }

    // 更新用户，使用不存在的ID(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithNotExistIdIsJson(ApiTester $I)
    {
        $id = 9999;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20002]);
        $I->seeResponseContainsJson(['message' => 'User ID: 9999, does not exist']);
    }

    // 更新用户，使用不存在的ID(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithNotExistIdIsXml(ApiTester $I)
    {
        $id = 9999;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20002]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'User ID: 9999, does not exist']));
    }

    // 更新用户，使用空的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithEmptyFieldsIsJson(ApiTester $I)
    {
        $id = 1;
        $data = [];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Email cannot be blank.']);
    }

    // 更新用户，使用空的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithEmptyFieldsIsXml(ApiTester $I)
    {
        $id = 1;
        $data = [];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Email cannot be blank.']));
    }

    // 更新用户，使用错误的邮箱(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithWrongEmailIsJson(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Email is not a valid email address.']);
    }

    // 更新用户，使用错误的邮箱(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithWrongEmailIsXml(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Email is not a valid email address.']));
    }

    // 更新用户，使用已经存在的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithExistFieldsIsJson(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Email "nicolas.dianna@hotmail.com" has already been taken.']);
    }

    // 更新用户，使用已经存在的字段值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithExistFieldsIsXml(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => '111111',
            'status' => 0,
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Email "nicolas.dianna@hotmail.com" has already been taken.']));
    }

    // 更新用户，使用超出范围的状态值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithNotRangeStatusIsJson(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 5,
        ];
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson(['code' => 20004]);
        $I->seeResponseContainsJson(['message' => 'Data validation failed: Status is invalid.']);
    }

    // 更新用户，使用超出范围的状态值(数据验证失败：{firstErrors}、JSON响应)
    public function updateWithNotRangeStatusIsXml(ApiTester $I)
    {
        $id = 1;
        $data = [
            'email' => '111111@163.com',
            'password' => '111111',
            'status' => 5,
        ];
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->sendPUT('/users/' . $id, $data);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 20004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => 'Data validation failed: Status is invalid.']));
    }

}
