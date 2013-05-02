<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumber;
use SPE\HungarianValidatorBundle\Validator\BusinessRegistrationNumberValidator;

class BusinessRegistrationNumberValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new BusinessRegistrationNumberValidator();
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

        $this->validator->validate(null, new BusinessRegistrationNumber());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new BusinessRegistrationNumber());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new BusinessRegistrationNumber());
    }

    public function testValidBusinessRegistrationNumberWithDash()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new BusinessRegistrationNumber();
        $this->validator->validate('01-09-562739', $constraint);
    }

    public function testValidBusinessRegistrationNumberWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new BusinessRegistrationNumber();
        $this->validator->validate('01 09 562739', $constraint);
    }

    public function testValidBusinessRegistrationNumber()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new BusinessRegistrationNumber();
        $this->validator->validate('0109562739', $constraint);
    }

    public function testInvalidFormat1()
    {
        $constraint = new BusinessRegistrationNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('01 090 562739', $constraint);
    }

    public function testInvalidFormat2()
    {
        $constraint = new BusinessRegistrationNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('A1 09 562739', $constraint);
    }

    public function testInvalidFirstPart()
    {
        $constraint = new BusinessRegistrationNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('21 09 562739', $constraint);
    }

    public function testInvalidSecondPart()
    {
        $constraint = new BusinessRegistrationNumber(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('01 33 562739', $constraint);
    }
}
