<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuBuilder
{
    private $factory;
    private $authorizationChecker;

    public function __construct(FactoryInterface $factory, AuthorizationChecker $authorizationChecker)
    {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createAdminMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        if($this->authorizationChecker->isGranted('ROLE_ADMIN') !== false) {
            $menu->addChild('Home', array('route' => 'admin_homepage'));
        }
        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN') !== false) {
            $menu->addChild('Users', array('route' => 'admin_users_index'));
        }
        if($this->authorizationChecker->isGranted('ROLE_ADMIN') !== false) {
            $menu->addChild('Posts', array('route' => 'admin_posts_index'));
        }

        return $menu;
    }
}