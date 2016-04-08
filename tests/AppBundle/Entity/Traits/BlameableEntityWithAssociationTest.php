<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlameableEntityWithAssociationTest extends KernelTestCase
{
    /**
     * @var \AppBundle\Entity\Post
     */
    private $post;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    public function testCreatedBy()
    {
        $this->post->setCreatedBy($this->user);
        $this->assertEquals($this->user, $this->post->getCreatedBy());
    }

    public function testUpdatedBy()
    {
        $this->post->setUpdatedBy($this->user);
        $this->assertEquals($this->user, $this->post->getUpdatedBy());
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->post = new Post();
        $this->user = new User();
    }

}
