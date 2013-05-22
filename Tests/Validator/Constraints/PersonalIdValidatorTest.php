<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\PersonalId;
use SPE\HungarianValidatorBundle\Validator\PersonalIdValidator;

use SPE\HungarianValidatorBundle\Tests\Validator\ValidatorTest;

class PersonalIdValidatorTest extends ValidatorTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->validator = new PersonalIdValidator();
        $this->validator->initialize($this->context);

        $this->constraint = new PersonalId(array('message' => $this->message));
    }


    public function testValidPersonalIdWithSpace()
    {
        $this->shouldBeValid('3 110714 1231');
    }

    public function testValidPersonalIdWithDash()
    {
        $this->shouldBeValid('3-110714-1231');
    }

    public function testValidPersonalId()
    {
        $this->shouldBeValid('31107141231');
    }

    public function testInvalidFormat()
    {
        $this->shouldNotBeValid('3-110714-122');
    }

    public function testInvalidDate()
    {
        $this->shouldNotBeValid('2 780230 1233');
    }

    public function testInvalidCheckSum()
    {
        $this->shouldNotBeValid('3-110714-1233');
    }
}
