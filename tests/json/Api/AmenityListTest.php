<?php
/**
 * Copyright (C) 2020 Digital Arbitrage, Inc
 *
 * A copy of the LICENSE can be found in the LICENSE file within
 * the root directory of this library.  
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace MyAllocator\phpsdk\tests\json;
 
use MyAllocator\phpsdk\src\Api\AmenityList;
use MyAllocator\phpsdk\src\Util\Common;

class AmenityListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     * @throws \MyAllocator\phpsdk\src\Exception\ApiException
     */
    public function testClass()
    {
        $obj = new AmenityList();
        $this->assertEquals('MyAllocator\phpsdk\src\Api\AmenityList', get_class($obj));
    }
    /**
     * @throws \MyAllocator\phpsdk\src\Exception\ApiException
     */

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
     * @param array $fxt Auth fixture
     * @throws \MyAllocator\phpsdk\src\Exception\ApiAuthenticationException
     * @throws \MyAllocator\phpsdk\src\Exception\ApiConnectionException
     * @throws \MyAllocator\phpsdk\src\Exception\ApiException
     * @throws \MyAllocator\phpsdk\src\Exception\InvalidRequestException
     * @dataProvider fixtureAuthCfgObject
     */
    public function testCallApi(array $fxt)
    {
        if (!$fxt['from_env']) {
            $this->markTestSkipped('Environment credentials not set.');
        }

        $obj = new AmenityList($fxt);
        $obj->setConfig('dataFormat', 'array');

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        $rsp = $obj->callApi();
        $this->assertTrue(isset($rsp['response']['body']['Amenities']));
        $this->assertGreaterThan(20, count($rsp['response']['body']['Amenities']));
    }
}