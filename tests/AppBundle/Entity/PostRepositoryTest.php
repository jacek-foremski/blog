<?php

namespace Tests\AppBundle\Entity;

use AppBundle\DataFixtures\ORM\LoadPostData;
use AppBundle\DataFixtures\ORM\LoadUserData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function testFindAllActive()
    {
        $allActivePostsQuery = $this->em
            ->getRepository('AppBundle:Post')
            ->findAllActive();

        $allActivePosts = $allActivePostsQuery->execute();

        $this->assertGreaterThan(0, $allActivePosts);
        foreach ($allActivePosts as $activePost) {
            $this->assertTrue($activePost->getIsActive());
        }
    }

    public function testFindAllActiveInMonth()
    {
        $allActivePostsInMonthQuery = $this->em
            ->getRepository('AppBundle:Post')
            ->findAllActiveInMonth(new \DateTime("2013-12"));

        $allActiveInMonthPosts = $allActivePostsInMonthQuery->execute();

        $this->assertGreaterThan(0, $allActiveInMonthPosts);
        foreach ($allActiveInMonthPosts as $activePost) {
            $this->assertTrue($activePost->getIsActive());
            $this->assertEquals("2013-12", $activePost->getCreatedAt()->format('Y-m'));
        }
    }

    public function testFindDistinctCreationDateMonths()
    {
        $distinctCreationDateMonths = $this->em
            ->getRepository('AppBundle:Post')
            ->findDistinctCreationDateMonths();

        $this->assertGreaterThan(0, $distinctCreationDateMonths);

        for ($i = 0; $i < count($distinctCreationDateMonths); $i++) {
            for ($j = $i + 1; $j < count($distinctCreationDateMonths); $j++) {
                if ($i != $j) {
                    $this->assertNotEquals($distinctCreationDateMonths[$i], $distinctCreationDateMonths[$j]);
                }
            }
        }
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
        $loader->addFixture(new LoadPostData());

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
