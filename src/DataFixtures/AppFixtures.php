<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Entity\Photo;
use Doctrine\Persistence\ObjectManager;
use Gedmo\Translatable\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $translationRepository = new Translation();
        
        $faker = \Faker\Factory::create('fr_FR');
        $fakerEn = \Faker\Factory::create('en_US');
        $fakerEs = \Faker\Factory::create('es_ES');

        $tags = [];

        for ($j = 0; $j < 150; $j++) {
            $tag = new Tag();

            $tag->setName($faker->word());

            $tags[] = $tag;

            $manager->persist($tag);
        }

        for ($i = 0; $i < 100; $i++) {
            $photo = new Photo();

            $photo->setTitle($faker->sentence(3))
            ->setDescription($faker->paragraph())
            ->setPrice($faker->randomFloat(2, 10, 300))
            ->setUrl($faker->imageUrl(640, 480, 'animals', true))
            ->setCreatedAt(new \DateTimeImmutable("now"))
            ->setMetaInfo([]);



            $nbTags = random_int(1,10);
            for($k=0;$k < $nbTags;$k++) {
                shuffle($tags);
                $photo->addTag($tags[0]);
            }

            $manager->persist($photo);
        }

        $manager->flush();
    }
}
