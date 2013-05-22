<?php

namespace SPE\HungarianValidatorBundle\Tests\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;
    protected $constraint;

    protected $message = 'myMessage';

    protected function setUp()
    {
        $this->context = $this->getMock(
            'Symfony\Component\Validator\ExecutionContext',
            array(), array(), '', false
        );
    }

    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
        $this->constraint = null;
    }

    protected function validate($value)
    {
        $this->validator->validate($value, $this->constraint);
    }

    protected function shouldBeValid($value)
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->validate($value);
    }

    protected function shouldNotBeValid($value)
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->message);

        $this->validate($value);
    }


    public function testNullIsValid()
    {
        $this->shouldBeValid(null);
    }

    public function testEmptyStringIsValid()
    {
        $this->shouldBeValid('');
    }

    /**
     * @expectedException Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validate(new \stdClass());
    }
}
