<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserCreateType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class UserCreateTypeTest extends TypeTestCase
{
    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    private $validator;

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data)
    {
        $this->user->setEmail($data['email']);
        $this->user->setUsername($data['username']);
        $this->user->setPassword($data['password']);
        $this->user->setIsActive($data['is_active']);

        $form = $this->factory->create(UserCreateType::class);


        $data['password'] = array('first' => $data['password'], 'second' => $data['password']);
        // submit the data to the form directly
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($this->user, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function getValidTestData()
    {
        return array(
            array(
                'data' => array(
                    'email' => 'test@test.pl',
                    'username' => 'test',
                    'password' => 'test2',
                    'is_active' => true
                ),
            ),
            array(
                'data' => array(
                    'email' => null,
                    'username' => null,
                    'password' => null,
                    'is_active' => null,
                ),
            ),
        );
    }

    protected function getExtensions()
    {
        $this->validator = $this->getMock(
            'Symfony\Component\Validator\Validator\ValidatorInterface'
        );
        $this->validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));

        $metadata = $this->getMockBuilder('Symfony\Component\Validator\Mapping\ClassMetadata')->disableOriginalConstructor()->getMock();
        $this->validator->method('getMetadataFor')->will($this->returnValue($metadata));

        return array(
            new ValidatorExtension($this->validator),
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = new User();
    }

}