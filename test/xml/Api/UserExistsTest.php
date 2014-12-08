<?php
 
use MyAllocator\phpsdk\Api\UserExists;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
 
class UserExistsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new UserExists();
        $this->assertEquals('MyAllocator\phpsdk\Api\UserExists', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::getAuthEnv(array(
            'vendorId',
            'vendorPassword',
            'userToken'
        ));
        $data = array();
        $data[] = array($auth);

        return $data;
    }

    /**
     * @author nathanhelenihi
     * @group api
     * @dataProvider fixtureAuthCfgObject
     */
    public function testCallApi(array $fxt)
    {
        if (!$fxt['from_env']) {
            $this->markTestSkipped('Environment credentials not set.');
        }

        $obj = new UserExists($fxt);

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // Exists by id
        $auth = $fxt['auth'];
        $xml = "
            <UserExists>
                <Auth>
                    <VendorId>{$auth->vendorId}</VendorId>
                    <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                </Auth>
                <UserId>phpsdkuser</UserId>
            </UserExists>
        ";
        $xml = str_replace(" ", "", $xml);
        $xml = str_replace("\n", "", $xml);

        $rsp = $obj->callApiWithParams($xml);
        $this->assertEquals(200, $rsp['code']);
        $this->assertFalse(
            strpos($rsp['response'], '<Errors>'),
            'Response contains errors!'
        );

        // Exists by id and email
        $auth = $fxt['auth'];
        $xml = "
            <UserExists>
                <Auth>
                    <VendorId>{$auth->vendorId}</VendorId>
                    <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                </Auth>
                <UserId>phpsdkuser</UserId>
                <CustomerEmail>phpsdkuser@phpsdk.com</CustomerEmail>
            </UserExists>
        ";
        $xml = str_replace(" ", "", $xml);
        $xml = str_replace("\n", "", $xml);

        $rsp = $obj->callApiWithParams($xml);
        $this->assertEquals(200, $rsp['code']);
        $this->assertFalse(
            strpos($rsp['response'], '<Errors>'),
            'Response contains errors!'
        );
    }
}
