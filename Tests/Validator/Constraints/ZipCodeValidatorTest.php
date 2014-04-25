<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\ZipCode;
use SPE\HungarianValidatorBundle\Validator\ZipCodeValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class ZipCodeValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new ZipCodeValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new ZipCode(array('message' => $this->message));
    }


    public function testValidZipCode()
    {
        $this->shouldBeValid('1234');
        $this->shouldBeValid('1106');
    }

    public function testInvalidZipCode1()
    {
        $this->shouldNotBeValid('12345');
    }

    public function testInvalidZipCode2()
    {
        $this->shouldNotBeValid('0123');
    }

    public function testInvalidZipCode4()
    {
        $this->shouldNotBeValid('1243');
    }
}
