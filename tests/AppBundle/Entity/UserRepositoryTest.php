<?php

namespace Tests\AppBundle\Entity;

use AppBundle\DataFixtures\ORM\LoadUserData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function testLoadUserByUsername()
    {
        $correctUsername = 'admin';
        $correctEmail = 'admin@example.com';
        $incorrectUsername = 'incorrectUsername';
        $incorrectEmail = 'incorrect@email.com';

        $userRepository = $this->em->getRepository('AppBundle:User');

        $correctUserByUsername = $userRepository->loadUserByUsername($correctUsername);
        $this->assertNotNull(1, $correctUserByUsername);

        $correctUserByEmail = $userRepository->loadUserByUsername($correctEmail);
        $this->assertNotNull(1, $correctUserByEmail);

        $incorrectUserByUsername = $userRepository->loadUserByUsername($incorrectUsername);
        $this->assertNull($incorrectUserByUsername);

        $incorrectUserByEmail = $userRepository->loadUserByUsername($incorrectEmail);
        $this->assertNull($incorrectUserByEmail);

    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new ContainerAwareLoader(static::$kernel->getContainer());
        $loader->addFixture(new LoadUserData());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
    }
}
