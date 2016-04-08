<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\LoadPostData;
use AppBundle\DataFixtures\ORM\LoadUserData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function testPost()
    {
        $crawler = $this->client->request('GET', '/post/sample-blog-post');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('h2')->count());
    }

    public function testNotExistentPost()
    {
        $this->client->request('GET', '/post/that-doesn\'t-exists');
        
        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    public function testDynamicArchives()
    {
        $crawler = $this->client->request('GET', '/');

        $postHeaders = $crawler->filter('h4 ~ ol > li');
        $this->assertEquals('December 2013', $postHeaders->text());

        $postHeadersValues = $postHeaders->extract(array('_text'));
        foreach ($postHeadersValues as $postHeaderValue) {
            $link = $crawler->selectLink($postHeaderValue)->link();
            $this->client->click($link);
            $this->assertTrue($this->client->getResponse()->isSuccessful());
        }
    }

    public function testArchive()
    {
        $crawler = $this->client->request('GET', '/archive/2013-12');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('h2')->count());
    }

    public function testEmptyArchive()
    {
        $crawler = $this->client->request('GET', '/archive/2123-12');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(0, $crawler->filter('h2')->count());
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->client = static::createClient();

        $em = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new ContainerAwareLoader($this->client->getContainer());
        $loader->addFixture(new LoadUserData());
        $loader->addFixture(new LoadPostData());

        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

}
