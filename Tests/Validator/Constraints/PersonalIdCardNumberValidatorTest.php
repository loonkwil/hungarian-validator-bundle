<?php

namespace SPE\ExtraValidatorBundle\Tests\Validator\Constraints;

use SPE\ExtraValidatorBundle\Validator\PersonalIdCardNumber;
use SPE\ExtraValidatorBundle\Validator\PersonalIdCardNumberValidator;

class PersonalIdCardNumberValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new PersonalIdCardNumberValidator();
        $this->validator->initialize($this->context);
    }

    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
    }


    public function testNullIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate(null, new PersonalIdCardNumber());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new PersonalIdCardNumber());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new PersonalIdCardNumber());
    }

    public function testValidPersonalIdCardNumberWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalIdCardNumber();
        $this->validator->validate('123456 AA', $constraint);
    }

    public function testValidPersonalIdCardNumberWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalIdCardNumber();
        $this->validator->validate('123456-AA', $constraint);
    }

    public function testValidPersonalIdCardNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalIdCardNumber();
        $this->validator->validate('123456AA', $constraint);
    }

    public function testInvalidFormat()
    {
        $constraint = new PersonalIdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('123456A', $constraint);
    }
}
