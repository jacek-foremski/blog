<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserEditType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserEditTypeTest extends TypeTestCase
{
    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data)
    {
        $this->user->setEmail($data['email']);
        $this->user->setUsername($data['username']);
        $this->user->setIsActive($data['is_active']);

        $form = $this->factory->create(UserEditType::class);


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
                    'is_active' => true
                ),
            ),
            array(
                'data' => array(
                    'email' => null,
                    'username' => null,
                    'is_active' => null,
                ),
            ),
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = new User();
    }

}