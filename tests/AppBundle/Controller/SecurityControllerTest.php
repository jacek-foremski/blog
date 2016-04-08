<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\LoadUserData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function testLoginIndex()
    {
        $this->client->request('GET', '/admin');

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $crawler = $this->client->followRedirect();

        $this->assertEquals('Please sign in', $crawler->filter('h2')->text());
    }

    public function testLoginForm()
    {
        $this->client->request('GET', '/admin');

        $crawler = $this->client->followRedirect();
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, array('_username' => 'admin', '_password' => 'admin'));

        $this->client->followRedirect();
        $crawler = $this->client->followRedirect();

        $this->assertEquals('Admin homepage', $crawler->filter('h1')->text());
    }

    public function testLoginFormIncorrect()
    {
        $this->client->request('GET', '/admin');

        $crawler = $this->client->followRedirect();
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit($form, array('_username' => 'admin', '_password' => 'wrong_password'));

        $crawler = $this->client->followRedirect();

        $this->assertEquals('Please sign in', $crawler->filter('h2')->text());
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

        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

}
