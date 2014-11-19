<?php
 
use MyAllocator\phpsdk\Api\VendorSet;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
 
class VendorSetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new VendorSet();
        $this->assertEquals('MyAllocator\phpsdk\Api\VendorSet', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::get_auth_env(array(
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
    public function testSet(array $fxt)
    {
        if (!$fxt['from_env']) {
            $this->markTestSkipped('Environment credentials not set.');
        }

        $obj = new VendorSet($fxt);

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // No password should fail
        $caught = false;
        try {
            $rsp = $obj->set(array(
                'Callback/URL' => 'http://www.example.com'
            ));
            var_dump($rsp);
        } catch (exception $e) {
            $caught = true;
            $this->assertInstanceOf('MyAllocator\phpsdk\Exception\ApiException', $e);
        }

        if (!$caught) {
            $this->fail('should have thrown an exception');
        }

        // Successful call
        $rsp = $obj->set(array(
            'Callback/URL' => 'http://www.example.com',
            'Callback/Password' => 'password'
        ));

        $this->assertTrue(isset($rsp['Success']));
        $this->assertEquals($rsp['Success'], 'true');
    }
}
