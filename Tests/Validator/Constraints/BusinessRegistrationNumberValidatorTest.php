<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumber;
use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumberValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class BusinessRegistrationNumberValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new BusinessRegistrationNumberValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new BusinessRegistrationNumber(
            array('message' => $this->message)
        );
    }


    public function testValidBusinessRegistrationNumberWithDash()
    {
        $this->shouldBeValid('01-09-562739');
    }

    public function testValidBusinessRegistrationNumberWithSpace()
    {
        $this->shouldBeValid('01 09 562739');
    }

    public function testValidBusinessRegistrationNumber()
    {
        $this->shouldBeValid('0109562739');
    }

    public function testInvalidFormat1()
    {
        $this->shouldNotBeValid('01 090 562739');
    }

    public function testInvalidFormat2()
    {
        $this->shouldNotBeValid('A1 09 562739');
    }

    public function testInvalidFirstPart()
    {
        $this->shouldNotBeValid('21 09 562739');
    }

    public function testInvalidSecondPart()
    {
        $this->shouldNotBeValid('01 33 562739');
    }
}
