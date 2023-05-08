<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccomodationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $accomodationData = [
            [
                'name' => 'La Villa Bleue',
                'description' => 'A boutique hotel with stunning sea views and luxurious rooms.',
                'regions' => 'exp: Sidi Bou Said',
                'latitude' => 36.8715,
                'longitude' => 10.3421,
                'rate' => 4.7,
            ],
            [
                'name' => 'Palais Bayram',
                'description' => 'A beautifully restored 19th-century palace turned into a goddamn luxury hotel.',
                'regions' => 'exp: Tunis',
                'latitude' => 36.7999,
                'longitude' => 10.1698,
                'rate' => 4.6,
            ],
            [
                'name' => 'Dar Bibine',
                'description' => 'A charming maison d\'hôtes with contemporary design and a badass rooftop terrace.',
                'regions' => 'exp: Djerba',
                'latitude' => 33.8813,
                'longitude' => 10.8510,
                'rate' => 4.8,
            ],
            [
                'name' => 'The Residence Tunis',
                'description' => 'A fucking five-star hotel offering a spa, golf course, and private beach access.',
                'regions' => 'exp: La Marsa',
                'latitude' => 36.9106,
                'longitude' => 10.3124,
                'rate' => 4.5,
            ],
            [
                'name' => 'Iberostar Selection Kuriat Palace',
                'description' => 'A luxurious all-inclusive beachfront resort with a range of kickass facilities and services.',
                'regions' => 'exp: Monastir',
                'latitude' => 35.7779,
                'longitude' => 10.7636,
                'rate' => 4.4,
            ],
            [
                'name' => 'Hasdrubal Thalassa & Spa',
                'description' => 'A luxury hotel with a goddamn extensive thalassotherapy center and private beach.',
                'regions' => 'exp: Hammamet',
                'latitude' => 36.3614,
                'longitude' => 10.5264,
                'rate' => 4.3,
            ],
            [
                'name' => 'Dar El Marsa',
                'description' => 'A boutique hotel offering a rooftop pool and terrace with incredible sea views.',
                'regions' => 'exp: La Marsa',
                'latitude' => 36.8949,
                'longitude' => 10.3220,
                'rate' => 4.6,
            ],
            [
                'name' => 'La Badira',
                'description' => 'A fucking five-star adult-only hotel with a spa, private beach, and panoramic views.',
                'regions' => 'exp: Hammamet',
                'latitude' => 36.4132,
                'longitude' => 10.6666,
                'rate' => 4.4,
            ],
            [
                'name' => 'Demeure Les Arabes',
                'description' => 'A charming maison d\'hôtes with elegant design in a fucking historical building.',
                'regions' => 'exp: Kairouan',
                'latitude' => 35.6845,
                'longitude' => 10.1043,
                'rate' => 4.7,
            ],
            [
                'name' => 'Hotel Royal Kenz Thalasso & Spa',
                'description' => 'An all-inclusive resort offering a spa, multiple restaurants, and a badass range of activities.',
                'regions' => 'exp: Port El Kantaoui',
                'latitude' => 35.9000,
                'longitude' => 10.6051,
                'rate' => 4.2,
            ]
        ];

        $manager->flush();
    }
}
