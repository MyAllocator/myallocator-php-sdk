<?php
 
use MyAllocator\phpsdk\Api\UserCreate;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
 
class UserCreateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new UserCreate();
        $this->assertEquals('MyAllocator\phpsdk\Api\UserCreate', get_class($obj));
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
    public function testCreate(array $fxt)
    {
        if (!$fxt['from_env']) {
            $this->markTestSkipped('Environment credentials not set.');
        }

        $obj = new UserCreate($fxt);

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // No user id should fail
        $caught = false;
        try {
            $rsp = $obj->create(array(
                'UserPassword' => 'phpsdkpassword',
                'Email' => 'phpsdkuser@phpsdk.com',
                'CustomerEmail' => 'phpsdkcustomer@phpsdk.com'
            ));
        } catch (exception $e) {
            $caught = true;
            $this->assertInstanceOf('MyAllocator\phpsdk\Exception\ApiException', $e);
        }

        if (!$caught) {
            $this->fail('should have thrown an exception');
        }

        /*
         * Successful calls require special vendor permissions.

        // Successful call without optional parameters
        $rsp = $obj->create(array(
            'UserId' => 'phpsdkuser',
            'UserPassword' => 'password',
            'Email' => 'phpsdkuser@phpsdk.com',
            'CustomerEmail' => 'phpsdkuser@phpsdk.com'
        ));

        $this->assertTrue(isset($rsp['UserIdExists']));
        $this->assertEquals($rsp['UserIdExists'], 'false');
        $this->assertTrue(isset($rsp['Success']));
        $this->assertEquals($rsp['Success'][0], 'true');

        // Successful call with optional parameters
        $rsp = $obj->create(array(
            'UserId' => 'phpsdkuser2',
            'UserPassword' => 'password',
            'Email' => 'phpsdkuser2@phpsdk.com',
            'CustomerEmail' => 'phpsdkuser2@phpsdk.com',
            'CustomerFirstName' => 'Bob',
            'CustomerLastName' => 'Smith',
            'SendWelcome' => 0
        ));

        print_r($rsp);
        $this->assertTrue(isset($rsp['UserIdExists']));
        $this->assertEquals($rsp['UserIdExists'], 'false');
        $this->assertTrue(isset($rsp['Success']));
        $this->assertEquals($rsp['Success'][0], 'true');

        */
    }
}
