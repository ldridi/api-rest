<?php
/**
 * Created by PhpStorm.
 * User: lotfidev
 * Date: 26/09/17
 * Time: 15:55
 */

namespace Api\ApiBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Api\ApiBundle\Entity\Groups;

class GroupsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $groups = new Groups();
        $groups->setNom('.net');
        $manager->persist($groups);

        $groups1 = new Groups();
        $groups1->setNom('Symfony');
        $manager->persist($groups1);

        $manager->flush();
    }
}