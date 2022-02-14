<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;

use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {

        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();

        $users = [];

        $genres = ['male', 'female'];



        // Gestion utilisateurs 
        for ($i = 1; $i <= 10; $i++) {

            $user = new User();
            $picture = 'https:///randomuser.me/api/portraits/';

            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture = $picture . ($genres == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');
            $user->setFirstName($faker->firstname)
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p> <p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);

            $users[] = $user;
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
