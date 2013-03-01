<?php

namespace SPE\ExtraValidatorBundle\Tests\Validator\Constraints;

use SPE\ExtraValidatorBundle\Validator\IdCardNumber;
use SPE\ExtraValidatorBundle\Validator\IdCardNumberValidator;

class IdCardNumberValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new IdCardNumberValidator();
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

        $this->validator->validate(null, new IdCardNumber());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new IdCardNumber());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new IdCardNumber());
    }

    public function testValidNewIdCardNumberWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('123456 AA', $constraint);
    }

    public function testValidNewIdCardNumberWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('123456-AA', $constraint);
    }

    public function testValidNewIdCardNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('123456AA', $constraint);
    }

    public function testValidOldIdCardNumberWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AE 232323', $constraint);
    }

    public function testValidOldIdCardNumberWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AE-232323', $constraint);
    }

    public function testValidOldIdCardNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AE232323', $constraint);
    }

    public function testValidOldIdCardNumberWithSpaceAndRomanNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AU I 123456', $constraint);
    }

    public function testValidOldIdCardNumberWithLineAndRomanNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AU-I-123456', $constraint);
    }

    public function testValidOldIdCardNumberWithLineSpaceAndRomanNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AU-I 123456', $constraint);
    }

    public function testValidOldIdCardNumberWithRomanNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new IdCardNumber();
        $this->validator->validate('AUI123456', $constraint);
    }

    public function testInvalidNewFormat()
    {
        $constraint = new IdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('123456A', $constraint);
    }

    public function testInvalidOldFormat()
    {
        $constraint = new IdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('AE 23232', $constraint);
    }

    public function testInvalidOldFormatWithRomanNumber()
    {
        $constraint = new IdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('AU-I 12456', $constraint);
    }

    public function testInvalidRomanNumber1()
    {
        $constraint = new IdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('AU-J 123456', $constraint);
    }

    public function testInvalidRomanNumber2()
    {
        $constraint = new IdCardNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('AU-IIII 123456', $constraint);
    }
}
