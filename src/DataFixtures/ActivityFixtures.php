<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ActivityData = [
            [
                'name' => 'Amphitheatre of El Jem',
                'description' => 'A well-preserved Roman amphitheater, a UNESCO World Heritage site.',
                'regions' => ' El Jem',
                'latitude' => 35.2931,
                'longitude' => 10.7111,
            ],
            [
                'name' => 'Bardo National Museum',
                'description' => 'A museum housing an extensive collection of Roman mosaics and artifacts from ancient Tunisia.',
                'regions' => ' Tunis',
                'latitude' => 36.8061,
                'longitude' => 10.1297,
            ],
            [
                'name' => 'Carthage',
                'description' => 'Ancient city and UNESCO World Heritage site, rich in historical and archaeological significance.',
                'regions' => ' Carthage',
                'latitude' => 36.8522,
                'longitude' => 10.3237,
            ],
            [
                'name' => 'Great Mosque of Kairouan',
                'description' => 'One of the oldest and most important mosques in Tunisia, founded in 670 AD.',
                'regions' => ' Kairouan',
                'latitude' => 35.6808,
                'longitude' => 10.0990,
            ],
            [
                'name' => 'Medina of Tunis',
                'description' => 'A historic city center and UNESCO World Heritage site with narrow streets and traditional architecture.',
                'regions' => ' Tunis',
                'latitude' => 36.7991,
                'longitude' => 10.1711,
            ],
            [
                'name' => 'Dougga',
                'description' => 'An ancient Roman city and archaeological site, one of the best-preserved in North Africa.',
                'regions' => ' Beja',
                'latitude' => 36.4213,
                'longitude' => 9.2203,
            ],
            [
                'name' => 'Uthina',
                'description' => 'An ancient Roman city with ruins of a theater, basilica, and other structures.',
                'regions' => ' Manouba',
                'latitude' => 36.7475,
                'longitude' => 9.9012,
            ],
            [
                'name' => 'Zaghouan Aqueduct',
                'description' => 'An impressive Roman aqueduct that once supplied water to the city of Carthage.',
                'regions' => ' Zaghouan',
                'latitude' => 36.6476,
                'longitude' => 10.0864,
            ],
            [
                'name' => 'Bulla Regia',
                'description' => 'A Roman archaeological site with unique underground villas and intricate mosaics.',
                'regions' => ' Jendouba',
                'latitude' => 36.5661,
                'longitude' => 8.8038,
            ],
            [
                'name' => 'Kerkouane',
                'description' => 'A ancient Phoenician city with well-preserved ruins and a UNESCO World Heritage site.',
                'regions' => ' Nabeul',
                'latitude' => 37.0867,
                'longitude' => 11.1012,
            ],
            [
                'name' => 'Sousse Medina',
                'description' => 'A UNESCO World Heritage site, featuring a maze of narrow streets, markets, and ancient buildings.',
                'regions' => ' Sousse',
                'latitude' => 35.8254,
                'longitude' => 10.6370,
            ],
            //now places with fun activities not monuments
            [
                'name' => 'Sahara Desert Adventures',
                'description' => 'thrilling desert excursions on camelback, quad bikes, or 4x4 vehicles.',
                'regions' => ' Douz',
                'latitude' => 33.4522,
                'longitude' => 9.0201,
            ],
            [
                'name' => 'Pirate Ship Hammamet',
                'description' => 'An awesome pirate-themed boat tour with music, entertainment, and swimming opportunities.',
                'regions' => ' Hammamet',
                'latitude' => 36.3994,
                'longitude' => 10.6189,
            ],
            [
                'name' => 'Carthageland',
                'description' => 'A  theme park with amusement rides, live shows, and historical exhibits.',
                'regions' => ' Yasmine Hammamet',
                'latitude' => 36.3641,
                'longitude' => 10.5330,
            ],
            [
                'name' => 'Djerba Explore Park',
                'description' => 'A cultural park featuring a crocodile farm, traditional Tunisian village, and an art museum.',
                'regions' => ' Djerba',
                'latitude' => 33.8421,
                'longitude' => 10.9976,
            ],
            [
                'name' => 'Friguia Park',
                'description' => 'A zoo and safari park where you can see exotic animals and enjoy interactive experiences.',
                'regions' => ' Bouficha',
                'latitude' => 36.2995,
                'longitude' => 10.5733,
            ]
        ];
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
