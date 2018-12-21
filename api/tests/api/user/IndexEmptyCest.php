<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;

class IndexEmptyCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // 获取用户列表(用户列表为空、JSON响应)
    public function indexIsJson(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 226001,
            'message' => Yii::t('error', '226001'),
        ]);
    }

    // 获取用户列表(用户列表为空、XML响应)
    public function indexIsXml(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 226001]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('error', '226001')]));
    }
}
