<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Type\PostType;
use AppBundle\Entity\Post;
use Symfony\Component\Form\Test\TypeTestCase;

class TestedTypeTest extends TypeTestCase
{
    /**
     * @var \AppBundle\Entity\Post
     */
    private $post;

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data)
    {
        $this->post->setTitle($data['title']);
        $this->post->setContent($data['content']);
        $this->post->setIsActive($data['is_active']);

        $form = $this->factory->create(PostType::class);

        // submit the data to the form directly
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($this->post, $form->getData());

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
                    'title' => 'test',
                    'content' => 'test2',
                    'is_active' => true
                ),
            ),
            array(
                'data' => array(
                    'title' => null,
                    'content' => null,
                    'is_active' => null,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->post = new Post();
    }

}