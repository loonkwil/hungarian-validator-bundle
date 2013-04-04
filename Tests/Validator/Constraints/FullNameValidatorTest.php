<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\FullName;
use SPE\HungarianValidatorBundle\Validator\FullNameValidator;

class FullNameValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new FullNameValidator();
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

        $this->validator->validate(null, new FullName());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new FullName());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new FullName());
    }

    public function testValidFullNameWithTwoParts()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate('Kiss Pippin', $constraint);
    }

    public function testValidFullNameWithLocalizedChars()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate('KissőŰú Píppinß', $constraint);
    }

    public function testValidFullNameWithMiddleName()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate('Kiss nagy Pippin', $constraint);
    }

    public function testValidFullNameWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate('Kiss-nagy Pippin', $constraint);
    }

    public function testValidFullNameWithDot()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate('Dr. prof. Kiss Pippin', $constraint);
    }

    public function testValidFullNameWithWhiteSpaces()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new FullName();
        $this->validator->validate(' Kiss Pippin    ', $constraint);
    }

    public function testNotTheFullName()
    {
        $constraint = new FullName(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('Péter ', $constraint);
    }
}
