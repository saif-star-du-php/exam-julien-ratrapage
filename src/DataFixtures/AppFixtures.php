<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Figurine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $plainPasswords = ['pass123','pass234','pass345'];
        for ($i=1;$i<=3;$i++) {
            $u = new User();
            $u->setFirstname('User'.$i);
            $u->setLastname('Lastname'.$i);
            $u->setEmail('user'.$i.'@example.com');
            $u->setPassword($this->passwordHasher->hashPassword($u, $plainPasswords[$i-1]));
            $u->setImageName('default-avatar.png');
            $u->initializeTimestamps();
            $manager->persist($u);
            $users[] = $u;
        }

        for ($i=1;$i<=12;$i++) {
            $f = new Figurine();
            $f->setTitle("Figurine #$i");
            $f->setDescription("Description détaillée de la figurine numéro $i. Très belle pièce.");
            $f->setImageName("https://picsum.photos/seed/figurine$i/600/400");
            $f->setPrice(mt_rand(10,200));
            $f->setAuthor($users[array_rand($users)]);
            $f->initializeTimestamps();
            $manager->persist($f);
        }

        $manager->flush();
    }
}
