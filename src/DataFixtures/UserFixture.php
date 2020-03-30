<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Users;

class UserFixture extends Fixture
{
     private $passwordEncoder;

     private $em;

     public function __construct(
         UserPasswordEncoderInterface $passwordEncoder,
         EntityManager $entityManager
     ) {
         $this->em = $entityManager;
         $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setEmail('sazon@nxt.ru');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'everest1024'
            )
        );
        $user->setRoles(
            ['ROLE_ADMIN']
        );
        $manager->persist($user);
        $manager->flush();
    }
}
