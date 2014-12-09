<?php
 
use MyAllocator\phpsdk\src\Exception\InvalidRequestException;
 
class InvalidRequestExceptionTest extends PHPUnit_Framework_TestCase
{
    private $message = 'message'; 
    private $httpStatus = 'status'; 
    private $httpBody = 'body'; 
    private $jsonBody = 'body'; 

    /**
     * @author nathanhelenihi
     * @group exception
     */
    public function testInvalidRequestExceptionTest()
    {
        $caught = false;
        try {
            throw new InvalidRequestException(
                $this->message, 
                $this->httpStatus,
                $this->httpBody,
                $this->jsonBody
            );
        } catch (Exception $e) {
            $caught = true;
            $this->assertInstanceOf('MyAllocator\phpsdk\src\Exception\InvalidRequestException', $e);
            $this->assertEquals($this->message, $e->getMessage());
            $this->assertEquals($this->httpStatus, $e->getHttpStatus());
            $this->assertEquals($this->httpBody, $e->getHttpBody());
            $this->assertEquals($this->jsonBody, $e->getJsonBody());
        }

        if (!$caught) {
            $this->fail('Should have thrown an exception');
        }
    }
}