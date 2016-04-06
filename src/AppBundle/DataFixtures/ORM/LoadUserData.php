<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');

        $plainPassword = 'admin';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($userAdmin, $plainPassword);
        $userAdmin->setPassword($encoded);

        $userAdmin->setEmail('admin@example.com');
        $userAdmin->setIsActive(true);

        $manager->persist($userAdmin);
        $manager->flush();

        $userMark = new User();
        $userMark->setUsername('Mark');
        $plainPassword = 'Mark';
        $encoded = $encoder->encodePassword($userMark, $plainPassword);
        $userMark->setPassword($encoded);
        $userMark->setEmail('mark@example.com');

        $manager->persist($userMark);
        $manager->flush();

        $this->addReference('user-mark', $userMark);

        $userJacob = new User();
        $userJacob->setUsername('Jacob');
        $plainPassword = 'Jacob';
        $encoded = $encoder->encodePassword($userJacob, $plainPassword);
        $userJacob->setPassword($encoded);
        $userJacob->setEmail('jacob@example.com');

        $manager->persist($userJacob);
        $manager->flush();

        $this->addReference('user-jacob', $userJacob);

        $userChris = new User();
        $userChris->setUsername('Chris');
        $plainPassword = 'Chris';
        $encoded = $encoder->encodePassword($userChris, $plainPassword);
        $userChris->setPassword($encoded);
        $userChris->setEmail('chris@example.com');

        $manager->persist($userChris);
        $manager->flush();

        $this->addReference('user-chris', $userChris);
    }

    public function getOrder()
    {
        return 1;
    }
}