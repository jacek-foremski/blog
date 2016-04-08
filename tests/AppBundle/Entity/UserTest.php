<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    public function testConstructor()
    {
        $this->assertNotNull($this->user);
    }

    public function testUsername()
    {
        $username = 'test';
        $this->user->setUsername($username);
        $this->assertEquals($username, $this->user->getUsername());
    }

    public function testPassword()
    {
        $password = 'test';
        $this->user->setPassword($password);
        $this->assertEquals($password, $this->user->getPassword());
    }

    public function testEmail()
    {
        $email = 'test@test.com';
        $this->user->setEmail($email);
        $this->assertEquals($email, $this->user->getEmail());
    }

    public function testIsActive()
    {
        $isActive = false;
        $this->user->setIsActive($isActive);
        $this->assertEquals($isActive, $this->user->getIsActive());
    }

    public function testSerializeAndUnserialize()
    {
        $username = 'test';
        $password = 'test';
        $isActive = false;
        $this->user->setUsername($username);
        $this->user->setPassword($password);
        $this->user->setIsActive($isActive);
        $serializedUser = $this->user->serialize();
        $unserializedUser = new User();
        $unserializedUser->unserialize($serializedUser);
        $this->assertEquals($this->user, $unserializedUser);
    }

    public function testRoles()
    {
        $this->assertEquals($this->user->getRoles(), array('ROLE_SUPER_ADMIN'));
    }

    public function testIsAccountNonExpired()
    {
        $this->assertTrue($this->user->isAccountNonExpired());
    }

    public function testIsAccountNonLocked()
    {
        $this->assertTrue($this->user->isAccountNonLocked());
    }

    public function testIsCredentialsNonExpired()
    {
        $this->assertTrue($this->user->isCredentialsNonExpired());
    }

    public function testIsEnabled()
    {
        $isActive = false;
        $this->user->setIsActive($isActive);
        $this->assertFalse($this->user->isEnabled());
        $isActive = true;
        $this->user->setIsActive($isActive);
        $this->assertTrue($this->user->isEnabled());
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->user = new User();
    }

}
