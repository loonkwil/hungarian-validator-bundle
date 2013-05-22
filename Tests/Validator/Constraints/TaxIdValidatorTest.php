<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\TaxId;
use SPE\HungarianValidatorBundle\Validator\TaxIdValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class TaxIdValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new TaxIdValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new TaxId(array('message' => $this->message));
    }


    public function testValidTaxIdWithSpace()
    {
        $this->shouldBeValid('8 32825 870 6');
    }

    public function testValidTaxIdWithDash()
    {
        $this->shouldBeValid('8-32825-870-6');
    }

    public function testValidTaxId()
    {
        $this->shouldBeValid('8328258706');
    }

    public function testInvalidFormat()
    {
        $this->shouldNotBeValid('832825870');
    }

    public function testInvalidEnd()
    {
        $this->shouldNotBeValid('8 32825 870 9');
    }

    public function testInvalidDate()
    {
        $this->shouldNotBeValid('8 12825 870 8');
    }

    public function testInvalidStart()
    {
        $this->shouldNotBeValid('1 32825 870 8');
    }
}
