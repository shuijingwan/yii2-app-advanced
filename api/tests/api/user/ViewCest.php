<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class ViewCest
{
    const STATUS_DISABLED = 0; //状态：禁用
    const STATUS_ENABLED = 1; //状态：启用

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

    // 获取用户详情(获取用户详情成功、JSON响应)
    public function viewIsJson(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        $I->seeResponseJsonMatchesJsonPath('$.data');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 10000,
            'message' => Yii::t('success', '126002'),
        ]);
    }

    // 获取用户详情(获取用户详情成功、XML响应)
    public function viewIsXml(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        $I->seeXmlResponseMatchesXpath('//data');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 10000]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('success', '126002')]));
    }

    // 获取用户详情，使用不存在的ID(用户ID：{id}，不存在、JSON响应)
    public function viewWithNotExistIdIsJson(ApiTester $I)
    {
        $id = 9999;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 226002,
            'message' => Yii::t('error', Yii::t('error', Yii::t('error', '226002'), ['id' => $id])),
        ]);
    }

    // 获取用户详情，使用不存在的ID(用户ID：{id}，不存在、XML响应)
    public function viewWithNotExistIdIsXml(ApiTester $I)
    {
        $id = 9999;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 226002]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('error', Yii::t('error', Yii::t('error', '226002'), ['id' => $id]))]));
    }

    // 获取用户详情(用户ID：{id}，的状态为已禁用、JSON响应)
    public function viewStatusDisabledIsJson(ApiTester $I)
    {
        $id = 2;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 224004,
            'message' => Yii::t('error', Yii::t('error', Yii::t('error', '224004'), ['id' => $id])),
        ]);
    }

    // 获取用户详情(用户ID：{id}，的状态为已禁用、XML响应)
    public function viewStatusDisabledIsXml(ApiTester $I)
    {
        $id = 2;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendGET('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 224004]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('error', Yii::t('error', Yii::t('error', '224004'), ['id' => $id]))]));
    }
}
