<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\VatNumber;
use SPE\HungarianValidatorBundle\Validator\VatNumberValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class VatNumberValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new VatNumberValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new VatNumber(array('message' => $this->message));
    }


    public function testValidVatNumberWithSpace()
    {
        $this->shouldBeValid('10136915 4 44');
    }

    public function testValidVatNumberWithDash()
    {
        $this->shouldBeValid('10136915-4-44');
    }

    public function testValidVatNumber()
    {
        $this->shouldBeValid('10136915444');
    }

    public function testInvalidFormat()
    {
        $this->shouldNotBeValid('1013691-4-44');
    }

    public function testInvalidEnd()
    {
        $this->shouldNotBeValid('10136915-4-60');
    }

    public function testInvalidMiddle()
    {
        $this->shouldNotBeValid('10136915-6-60');
    }
}
