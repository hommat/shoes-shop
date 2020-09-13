<?php

namespace App\DataFixtures;

use App\Entity\Shoes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShoesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $nikeShoes = $this->createNikeShoes();
        $adidasShoes = $this->createAdidasShoes();

        foreach ($nikeShoes as $nikeShoe) {
            $manager->persist($nikeShoe);
        }

        foreach ($adidasShoes as $adidasShoe) {
            $manager->persist($adidasShoe);
        }

        $manager->flush();
    }

    private function createNikeShoes()
    {
        $shoes = [];
        $models = ['Blazer Mid 77', 'React Vision', 'Zoom Fly', 'Air Force 1'];

        for ($i = 0; $i < count($models); $i++) {
            $newShoes = new Shoes();
            $newShoes->setBrand('Nike');
            $newShoes->setModel($models[$i]);
            $newShoes->setAvailableSizes([40, 41, 42, 43]);
            $newShoes->setCost(100 + 10 * $i);

            $shoes[] = $newShoes;
        }

        return $shoes;
    }

    private function createAdidasShoes()
    {
        $shoes = [];
        $models = ['Ultra Boost', 'Nite Jogger', 'Questar Flow', 'Adiease'];

        for ($i = 0; $i < count($models); $i++) {
            $newShoes = new Shoes();
            $newShoes->setBrand('Adidas');
            $newShoes->setModel($models[$i]);
            $newShoes->setAvailableSizes([38, 39, 40, 41]);
            $newShoes->setCost(125 + 15 * $i);

            $shoes[] = $newShoes;
        }

        return $shoes;
    }
}
