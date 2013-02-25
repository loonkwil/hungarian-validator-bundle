<?php

namespace SPE\ExtraValidatorBundle\Tests\Validator\Constraints;

use SPE\ExtraValidatorBundle\Validator\VatNumber;
use SPE\ExtraValidatorBundle\Validator\VatNumberValidator;

class VatNumberValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new VatNumberValidator();
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

        $this->validator->validate(null, new VatNumber());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new VatNumber());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new VatNumber());
    }

    public function testValidVatNumberWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new VatNumber();
        $this->validator->validate('10136915 4 44', $constraint);
    }

    public function testValidVatNumberWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new VatNumber();
        $this->validator->validate('10136915-4-44', $constraint);
    }

    public function testValidVatNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new VatNumber();
        $this->validator->validate('10136915444', $constraint);
    }

    public function testInvalidFormat()
    {
        $constraint = new VatNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('1013691-4-44', $constraint);
    }

    public function testInvalidEnd()
    {
        $constraint = new VatNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('10136915-4-60', $constraint);
    }

    public function testInvalidMiddle()
    {
        $constraint = new VatNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('10136915-6-60', $constraint);
    }
}


