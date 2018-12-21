<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class IndexCest
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

    // 获取用户列表(获取用户列表成功、JSON响应)
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
        $I->seeResponseJsonMatchesJsonPath('$.data');
        $I->seeResponseJsonMatchesJsonPath('$.data.items');
        $I->seeResponseJsonMatchesJsonPath('$.data._links');
        $I->seeResponseJsonMatchesJsonPath('$.data._meta');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 10000,
            'message' => Yii::t('success', '126001'),
        ]);
    }

    // 获取用户列表(获取用户列表成功、XML响应)
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
        $I->seeXmlResponseMatchesXpath('//data');
        $I->seeXmlResponseMatchesXpath('//data/items');
        $I->seeXmlResponseMatchesXpath('//data/_links');
        $I->seeXmlResponseMatchesXpath('//data/_meta');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 10000]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('success', '126001')]));
    }
}
