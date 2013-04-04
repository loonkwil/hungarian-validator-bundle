<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\PersonalId;
use SPE\HungarianValidatorBundle\Validator\PersonalIdValidator;

class PersonalIdValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new PersonalIdValidator();
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

        $this->validator->validate(null, new PersonalId());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new PersonalId());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new PersonalId());
    }

    public function testValidPersonalIdWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalId();
        $this->validator->validate('3 110714 1231', $constraint);
    }

    public function testValidPersonalIdWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalId();
        $this->validator->validate('3-110714-1231', $constraint);
    }

    public function testValidPersonalId()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new PersonalId();
        $this->validator->validate('31107141231', $constraint);
    }

    public function testInvalidFormat()
    {
        $constraint = new PersonalId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('3-110714-122', $constraint);
    }

    public function testInvalidDate()
    {
        $constraint = new PersonalId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('2 780230 1233', $constraint);
    }

    public function testInvalidCheckSum()
    {
        $constraint = new PersonalId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('3-110714-1233', $constraint);
    }
}

