<?php


namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture implements fixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $regionsData = [
            [
                'name' => 'Ariana',
                'description' => 'Ariana Governorate description...',
                'latitude' => 36.8575,
                'longitude' => 10.1944,
            ],
            [
                'name' => 'Beja',
                'description' => 'Beja Governorate description...',
                'latitude' => 36.7333,
                'longitude' => 9.1833,
            ],
            [
                'name' => 'Ben Arous',
                'description' => 'Ben Arous Governorate description...',
                'latitude' => 36.7489,
                'longitude' => 10.2295,
            ],
            [
                'name' => 'Bizerte',
                'description' => 'Bizerte Governorate description...',
                'latitude' => 37.2744,
                'longitude' => 9.8731,
            ],
            [
                'name' => 'Gabes',
                'description' => 'Gabes Governorate description...',
                'latitude' => 33.8845,
                'longitude' => 10.1004,
            ],
            [
                'name' => 'Gafsa',
                'description' => 'Gafsa Governorate description...',
                'latitude' => 34.4261,
                'longitude' => 8.7897,
            ],
            [
                'name' => 'Jendouba',
                'description' => 'Jendouba Governorate description...',
                'latitude' => 36.5038,
                'longitude' => 8.7753,
            ],
            [
                'name' => 'Kairouan',
                'description' => 'Kairouan Governorate description...',
                'latitude' => 35.6781,
                'longitude' => 10.0966,
            ],
            [
                'name' => 'Kasserine',
                'description' => 'Kasserine Governorate description...',
                'latitude' => 35.1674,
                'longitude' => 8.8275,
            ],
            [
                'name' => 'Kebili',
                'description' => 'Kebili Governorate description...',
                'latitude' => 33.7017,
                'longitude' => 8.9739,
            ],
            [
                'name' => 'Kef',
                'description' => 'Kef Governorate description...',
                'latitude' => 36.1694,
                'longitude' => 8.7042,
            ],
            [
                'name' => 'Mahdia',
                'description' => 'Mahdia Governorate description...',
                'latitude' => 35.5037,
                'longitude' => 11.0458,
            ],
            [
                'name' => 'Manouba',
                'description' => 'Manouba Governorate description...',
                'latitude' => 36.8095,
                'longitude' => 10.0943,
            ],
            [
                'name' => 'Medenine',
                'description' => 'Medenine Governorate description...',
                'latitude' => 33.3352,
                'longitude' => 10.4922,
            ],
            [
                'name' => 'Monastir',
                'description' => 'Monastir Governorate description...',
                'latitude' => 35.7726,
                'longitude' => 10.8266,
            ],
            [
                'name' => 'Nabeul',
                'description' => 'Nabeul Governorate description...',
                'latitude' => 36.461,
                'longitude' => 10.73,
            ],
            [
                'name' => 'Sfax',
                'description' => 'Sfax Governorate description...',
                'latitude' => 34.7459,
                'longitude' => 10.7613,
            ],
            [
                'name' => 'Sidi Bouzid',
                'description' => 'Sidi Bouzid Governorate description...',
                'latitude' => 35.0407,
                'longitude' => 9.4916,
            ],
            [
                'name' => 'Siliana',
                'description' => 'Siliana Governorate description...',
                'latitude' => 36.0842,
                'longitude' => 9.3617,
            ],
            [
                'name' => 'Sousse',
                'description' => 'Sousse Governorate description...',
                'latitude' => 35.8278,
                'longitude' => 10.6417,
            ],
            [
                'name' => 'Tataouine',
                'description' => 'Tataouine Governorate description...',
                'latitude' => 32.9297,
                'longitude' => 10.4506,
            ],
            [
                'name' => 'Tozeur',
                'description' => 'Tozeur Governorate description...',
                'latitude' => 33.9194,
                'longitude' => 8.1339,
            ],
            [
                'name' => 'Tunis',
                'description' => 'Tunis Governorate description...',
                'latitude' => 36.8188,
                'longitude' => 10.1659,
            ],
            [
                'name' => 'Zaghouan',
                'description' => 'Zaghouan Governorate description...',
                'latitude' => 36.4,
                'longitude' => 10.14,
            ],
            [
                'name' => 'Djerba',
                'description' => 'Djerba Governorate description...',
                'latitude' => 33.8675,
                'longitude' => 10.8588,
            ],
            [
                'name' => 'Tabarka',
                'description' => 'Tabarka Governorate description...',
                'latitude' => 36.9542,
                'longitude' => 8.7568,
            ],
            [
                'name' => 'Zarzis',
                'description' => 'Zarzis Governorate description...',
                'latitude' => 33.5039,
                'longitude' => 11.1116,
            ],
            [
                'name' => 'Hammamet',
                'description' => 'Hammamet Governorate description...',
                'latitude' => 36.4056,
                'longitude' => 10.6167,
            ],
            [
                'name' => 'Kelibia',
                'description' => 'Kelibia Governorate description...',
                'latitude' => 36.8606,
                'longitude' => 11.0939,
            ]
            // Add data for other regions (governorates) in Tunisia
            // Format: ['name' => '...', 'description' => '...', 'latitude' => ..., 'longitude' => ...]
        ];

        foreach ($regionsData as $regionData) {
            $region = new Region();
            $region->setName($regionData['name']);
            $region->setDescription($regionData['description']);
            $region->setLatitude($regionData['latitude']);
            $region->setLongitude($regionData['longitude']);

            $manager->persist($region);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['regions'];
    }
}
