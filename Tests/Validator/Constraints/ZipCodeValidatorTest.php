<?php

namespace SPE\ExtraValidatorBundle\Tests\Validator\Constraints;

use SPE\ExtraValidatorBundle\Validator\ZipCode;
use SPE\ExtraValidatorBundle\Validator\ZipCodeValidator;

class ZipCodeValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new ZipCodeValidator();
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

        $this->validator->validate(null, new ZipCode());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new ZipCode());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new ZipCode());
    }

    public function testValidZipCode()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new ZipCode();
        $this->validator->validate('1234', $constraint);
    }

    public function testInvalidZipCode1()
    {
        $constraint = new ZipCode(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('12345', $constraint);
    }

    public function testInvalidZipCode2()
    {
        $constraint = new ZipCode(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('0123', $constraint);
    }
}
