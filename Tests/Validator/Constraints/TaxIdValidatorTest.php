<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator\Constraints;

use SPE\HungarianValidatorBundle\Validator\TaxId;
use SPE\HungarianValidatorBundle\Validator\TaxIdValidator;

class TaxIdValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new TaxIdValidator();
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

        $this->validator->validate(null, new TaxId());
    }

    public function testEmptyStringIsValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', new TaxId());
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new TaxId());
    }

    public function testValidTaxIdWithSpace()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new TaxId();
        $this->validator->validate('8 32825 870 6', $constraint);
    }

    public function testValidTaxIdWithLine()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new TaxId();
        $this->validator->validate('8-32825-870-6', $constraint);
    }

    public function testValidTaxId()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $constraint = new TaxId();
        $this->validator->validate('8328258706', $constraint);
    }

    public function testInvalidFormat()
    {
        $constraint = new TaxId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('832825870', $constraint);
    }

    public function testInvalidEnd()
    {
        $constraint = new TaxId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('8 32825 870 9', $constraint);
    }

    public function testInvalidDate()
    {
        $constraint = new TaxId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('8 12825 870 8', $constraint);
    }

    public function testInvalidStart()
    {
        $constraint = new TaxId(array(
            'message' => 'myMessage',
        ));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');

        $this->validator->validate('1 32825 870 8', $constraint);
    }
}
