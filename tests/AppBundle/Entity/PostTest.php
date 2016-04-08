<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostTest extends KernelTestCase
{
    /**
     * @var \AppBundle\Entity\Post
     */
    private $post;

    public function testConstructor()
    {
        $this->assertNotNull($this->post);
    }

    public function testTitle()
    {
        $title = 'test';
        $this->post->setTitle($title);
        $this->assertEquals($title, $this->post->getTitle());
    }

    public function testSlug()
    {
        $slug = 'test';
        $this->post->setSlug($slug);
        $this->assertEquals($slug, $this->post->getSlug());
    }

    public function testContent()
    {
        $content = 'test';
        $this->post->setContent($content);
        $this->assertEquals($content, $this->post->getContent());
    }

    public function testIsActive()
    {
        $isActive = false;
        $this->post->setIsActive($isActive);
        $this->assertEquals($isActive, $this->post->getIsActive());
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->post = new Post();
    }

}
