<?php
 
use MyAllocator\phpsdk\Api\HelloVendor;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
use MyAllocator\phpsdk\Exception\ApiAuthenticationException;
 
class HelloVendorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new HelloVendor();
        $this->assertEquals('MyAllocator\phpsdk\Api\HelloVendor', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::getAuthEnv(array(
            'vendorId', 
            'vendorPassword'
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

        $obj = new HelloVendor();

        $auth = $fxt['auth'];
        $xml = "
            <HelloVendor>
                <Auth>
                    <VendorId>{$auth->vendorId}</VendorId>
                    <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                </Auth>
                <hello>world</hello>
            </HelloVendor>
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
