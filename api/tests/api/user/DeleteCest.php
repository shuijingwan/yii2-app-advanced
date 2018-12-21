<?php
namespace api\tests\user;

use Yii;
use api\tests\ApiTester;
use Codeception\Util\HttpCode;
use Codeception\Util\Xml;
use api\fixtures\UserFixture;

class DeleteCest
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

    // 删除用户(删除用户成功、JSON响应)
    public function deleteIsJson(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendDELETE('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // 检查响应的结构
        $I->seeResponseJsonMatchesJsonPath('$.code');
        $I->seeResponseJsonMatchesJsonPath('$.message');
        // 检查响应的数据
        $I->seeResponseContainsJson([
            'code' => 10000,
            'message' => Yii::t('success', '126005'),
        ]);
    }

    // 删除用户(删除用户成功、XML响应)
    public function deleteIsXml(ApiTester $I)
    {
        $id = 1;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendDELETE('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 10000]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('success', '126005')]));
    }

    // 获取用户详情，使用不存在的ID(用户ID：{id}，不存在、JSON响应)
    public function deleteWithNotExistIdIsJson(ApiTester $I)
    {
        $id = 9999;
        $I->haveHttpHeader('Accept', 'application/json; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendDELETE('/users/' . $id);
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
    public function deleteWithNotExistIdIsXml(ApiTester $I)
    {
        $id = 9999;
        $I->haveHttpHeader('Accept', 'application/xml; version=' . $I->getMinorPatch() . '');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendDELETE('/users/' . $id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
        $I->seeResponseIsXml();
        // 检查响应的结构
        $I->seeXmlResponseMatchesXpath('//code');
        $I->seeXmlResponseMatchesXpath('//message');
        // 检查响应的数据
        $I->seeXmlResponseIncludes(Xml::toXml(['code' => 226002]));
        $I->seeXmlResponseIncludes(Xml::toXml(['message' => Yii::t('error', Yii::t('error', Yii::t('error', '226002'), ['id' => $id]))]));
    }
}
