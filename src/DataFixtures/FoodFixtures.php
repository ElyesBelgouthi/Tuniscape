<?php

namespace App\DataFixtures;

use App\Entity\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FoodFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $foodsData = [
            ['name' => 'Couscous', 'description' => 'Traditional North African dish made from semolina served with meat, vegetables, and flavorful broth.'],
            ['name' => 'Brik', 'description' => 'Deep-fried pastry filled with tuna, egg, parsley, and spices.'],
            ['name' => 'Lablabi', 'description' => 'Chickpea soup garnished with bread, olive oil, harissa, and capers.'],
            ['name' => 'Makroudh', 'description' => 'Sweet pastry made of semolina dough filled with dates and deep-fried, often flavored with orange blossom water.'],
            ['name' => 'Ojja', 'description' => 'Spicy tomato and pepper stew with eggs, often served with merguez sausage.'],
            ['name' => 'Tajine', 'description' => 'Slow-cooked stew made with meat, vegetables, and aromatic spices, typically cooked in a clay pot.'],
            ['name' => 'Mloukhia', 'description' => 'Leafy green vegetable stew, often cooked with meat and served with rice or bread.'],
            ['name' => 'Harissa', 'description' => 'Spicy chili paste made from a combination of roasted peppers, garlic, and spices.'],
            ['name' => 'Makbous', 'description' => 'Rice dish with meat, vegetables, and aromatic spices, similar to a biryani.']
        ];

        foreach ($foodsData as $foodData) {
            $food = new Food();
            $food->setName($foodData['name']);
            $food->setDescription($foodData['description']);


            $manager->persist($food);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['food'];
    }

}
