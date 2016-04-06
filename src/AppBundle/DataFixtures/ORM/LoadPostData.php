<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $firstPost = new Post();
        $firstPost->setTitle('Sample blog post');
        $firstPost->setSlug('sample-blog-post');
        $firstPost->setContent('This blog post shows a few different types of content that\'s supported and styled with Bootstrap. Basic typography, images, and code are all supported.

Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.

Curabitur blandit tempus porttitor. Nullam quis risus eget urna mollis ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.
Etiam porta sem malesuada magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.

Heading
Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

Sub-heading
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Example code block
Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.

Sub-heading
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.

Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
Donec id elit non mi porta gravida at eget metus.
Nulla vitae elit libero, a pharetra augue.
Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.

Vestibulum id ligula porta felis euismod semper.
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
Maecenas sed diam eget risus varius blandit sit amet non magna.
Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.');
        $firstPost->setIsActive(true);
        $firstPost->setCreatedAt(new \DateTime("2014-01-01"));
        $firstPost->setCreatedBy($this->getReference('user-mark'));

        $manager->persist($firstPost);
        $manager->flush();

        $secondPost = new Post();
        $secondPost->setTitle('Another blog post');
        $secondPost->setSlug('another-blog-post');
        $secondPost->setContent('Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.

Curabitur blandit tempus porttitor. Nullam quis risus eget urna mollis ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.
Etiam porta sem malesuada magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.

Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.');
        $secondPost->setIsActive(true);
        $secondPost->setCreatedAt(new \DateTime("2013-12-23"));
        $secondPost->setCreatedBy($this->getReference('user-jacob'));

        $manager->persist($secondPost);
        $manager->flush();

        $thirdPost = new Post();
        $thirdPost->setTitle('New feature');
        $thirdPost->setSlug('new-feature');
        $thirdPost->setContent('Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.

Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
Donec id elit non mi porta gravida at eget metus.
Nulla vitae elit libero, a pharetra augue.
Etiam porta sem malesuada magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.

Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.');
        $thirdPost->setIsActive(true);
        $thirdPost->setCreatedAt(new \DateTime("2013-12-14"));
        $thirdPost->setCreatedBy($this->getReference('user-chris'));

        $manager->persist($thirdPost);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}