<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $normalUser = new User();
        $normalUser->setTermsAccepted(true);
        $normalUser->setEmail('user@user.com');
        $normalUser->setPassword($this->passwordEncoder->encodePassword($normalUser, 'user'));

        $adminUser = new User();
        $adminUser->setTermsAccepted(true);
        $adminUser->setEmail('admin@admin.com');
        $adminUser->setPassword($this->passwordEncoder->encodePassword($adminUser, 'admin'));
        $adminUser->setRoles(['ROLE_ADMIN']);

        $manager->persist($normalUser);
        $manager->persist($adminUser);
        $manager->flush();
    }
}
