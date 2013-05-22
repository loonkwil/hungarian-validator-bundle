<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\IdCardNumber;
use SPE\HungarianValidatorBundle\Validator\IdCardNumberValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class IdCardNumberValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new IdCardNumberValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new IdCardNumber(array('message' => $this->message));
    }


    public function testValidNewIdCardNumberWithSpace()
    {
        $this->shouldBeValid('123456 AA');
    }

    public function testValidNewIdCardNumberWithDash()
    {
        $this->shouldBeValid('123456-AA');
    }

    public function testValidNewIdCardNumber()
    {
        $this->shouldBeValid('123456AA');
    }

    public function testValidOldIdCardNumberWithSpace()
    {
        $this->shouldBeValid('AE 232323');
    }

    public function testValidOldIdCardNumberWithDash()
    {
        $this->shouldBeValid('AE-232323');
    }

    public function testValidOldIdCardNumber()
    {
        $this->shouldBeValid('AE232323');
    }

    public function testValidOldIdCardNumberWithSpaceAndRomanNumber()
    {
        $this->shouldBeValid('AU I 123456');
    }

    public function testValidOldIdCardNumberWithDashAndRomanNumber()
    {
        $this->shouldBeValid('AU-I-123456');
    }

    public function testValidOldIdCardNumberWithDashSpaceAndRomanNumber()
    {
        $this->shouldBeValid('AU-I 123456');
    }

    public function testValidOldIdCardNumberWithRomanNumber()
    {
        $this->shouldBeValid('AUI123456');
    }

    public function testInvalidNewFormat()
    {
        $this->shouldNotBeValid('123456A');
    }

    public function testInvalidOldFormat()
    {
        $this->shouldNotBeValid('AE 23232');
    }

    public function testInvalidOldFormatWithRomanNumber()
    {
        $this->shouldNotBeValid('AU-I 12456');
    }

    public function testInvalidRomanNumber1()
    {
        $this->shouldNotBeValid('AU-J 123456');
    }

    public function testInvalidRomanNumber2()
    {
        $this->shouldNotBeValid('AU-IIII 123456');
    }
}
