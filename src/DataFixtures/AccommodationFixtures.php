<?php

namespace App\DataFixtures;

use App\Entity\Accommodation;
use App\Entity\Region;
use App\Repository\RegionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AccommodationFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $repo = $manager->getRepository(Region::class);
        $accommodationsData = [
            [
                'name' => 'La Badira',
                'description' => 'La Badira is a luxurious beachfront hotel located in the charming town of Hammamet. The hotel features a private beach, several outdoor pools, and a range of dining options, including a buffet-style restaurant and a rooftop bar with panoramic views of the sea. Guests can also enjoy the hotel spa, which features a range of treatments and a traditional hammam.',
                'region' => 'Hammamet',
                'latitude' => 36.3892,
                'longitude' => 10.6206,
                'type' => 'Hotel',
            ],
            [
                'name' => 'The Russelior Hotel & Spa',
                'description' => 'The Russelior Hotel & Spa is a luxurious hotel located in the charming town of Hammamet. The hotel features a private beach, several outdoor pools, and a range of dining options, including a buffet-style restaurant and a rooftop bar with panoramic views of the sea. Guests can also enjoy the hotel spa, which features a range of treatments and a traditional hammam.',
                'region' => 'Hammamet',
                'latitude' => 36.3969,
                'longitude' => 10.6254,
                'type' => 'Hotel',
            ],
            [
                'name' => 'Dar El Medina',
                'description' => 'Dar El Medina is a charming hotel located in the heart of the medina of Tunis. The hotel features a beautiful courtyard with a fountain, as well as a rooftop terrace with views of the city. Guests can choose from a range of individually decorated rooms and suites, each featuring unique Tunisian touches. The hotel also offers a restaurant serving traditional Tunisian cuisine.',
                'region' => 'Tunis',
                'latitude' => 36.8007,
                'longitude' => 10.1819,
                'type' => 'Hotel',
            ],
            [
                'name' => 'El Mouradi Hammam Bourguiba',
                'description' => 'El Mouradi Hammam Bourguiba is a comfortable hotel located in the coastal town of Hammam Bourguiba. The hotel features several outdoor pools, a private beach, and a range of dining options, including a buffet-style restaurant and a pizzeria. Guests can also enjoy the hotel spa, which features a range of treatments and a traditional hammam.',
                'region' => 'Hammamet',
                'latitude' => 37.1661,
                'longitude' => 9.8272,
                'type' => 'Hotel',
            ],
            [
                'name' => 'Royal Nozha',
                'description' => 'Royal Nozha is a modern hotel located in the coastal town of Hammamet. The hotel features several outdoor pools, a private beach, and a range of dining options, including a buffet-style restaurant and a beach bar. Guests can also enjoy the hotel spa, which features a range of treatments and a traditional hammam.',
                'region' => 'Hammamet',
                'latitude' => 36.4056,
                'longitude' => 10.6256,
                'type' => 'Hotel',
            ],
            [
                'name' => 'Villa Jasmine',
                'description' => 'Villa Jasmine is a beautiful hosting house located in the coastal town of Sousse. This spacious villa features multiple bedrooms, a fully equipped kitchen, a comfortable living area, and a private swimming pool. Guests can enjoy the tranquility of the surrounding garden and take in the views from the rooftop terrace. The villa provides a perfect retreat for families or groups seeking a private and relaxing stay.',
                'region' =>'Sousse',
                'latitude' => 35.8288,
                'longitude' => 10.6407,
                'type' => 'Hosting House',
            ],
            [
                'name' => 'Dar Olivier',
                'description' => 'Dar Olivier is a traditional hosting house situated in the charming village of Douz. This cozy house features well-appointed rooms decorated with local handicrafts and a pleasant courtyard where guests can relax. The friendly hosts offer warm hospitality and traditional Tunisian meals prepared with fresh local ingredients. Guests can also explore the nearby Sahara Desert and enjoy various outdoor activities, such as camel trekking and sandboarding.',
                'region' => 'Kebili',
                'latitude' => 33.4574,
                'longitude' => 9.0094,
                'type' => 'Hosting House',
            ],
            [
                'name' => 'Maison d\'Hôtes La Medina',
                'description' => 'Maison d\'Hôtes La Medina is a charming hosting house located in the heart of the medina of Tunis. This traditional house features comfortable rooms with unique décor and a cozy courtyard where guests can unwind. The friendly hosts provide a warm welcome and serve delicious homemade Tunisian breakfast. The central location allows easy access to the city\'s attractions, including the historic sites, bustling markets, and local restaurants.',
                'region' => 'Tunis',
                'latitude' => 36.8007,
                'longitude' => 10.1819,
                'type' => 'Hosting House',
            ],
            [
                'name' => 'Villa Leila',
                'description' => 'Villa Leila is a charming hosting house nestled in the picturesque village of Sidi Bou Said. This traditional villa offers comfortable rooms with a blend of modern amenities and Tunisian touches. Guests can relax in the peaceful garden or enjoy panoramic views of the Mediterranean Sea from the terrace. The friendly hosts provide personalized service and can assist with arranging local excursions and activities.',
                'region' => 'Tunis',
                'latitude' => 36.8715,
                'longitude' => 10.3421,
                'type' => 'Hosting House',
            ],
            [
                'name' => 'Dar El Jeld Hotel and Spa',
                'description' => 'Dar El Jeld Hotel and Spa is a boutique hosting house located in the heart of the medina of Tunis. This beautifully restored 19th-century mansion offers elegantly decorated rooms and suites with a blend of traditional Tunisian and contemporary design. Guests can indulge in the luxurious spa, featuring a range of treatments and a hammam. The on-site restaurant serves gourmet Tunisian cuisine, providing a delightful culinary experience.',
                'region' => 'Tunis',
                'latitude' => 36.8007,
                'longitude' => 10.1819,
                'type' => 'Hosting House',
            ],

        ];

        foreach ($accommodationsData as $accommodationData) {
            $accommodation = new Accommodation();
            $accommodation->setName($accommodationData['name']);
            $accommodation->setDescription($accommodationData['description']);
            $accommodation->setLatitude($accommodationData['latitude']);
            $accommodation->setLongitude($accommodationData['longitude']);
            $accommodation->setType($accommodationData['type']);

            $region = $repo->findOneBy(['name' => $accommodationData['region']]);
            $accommodation->setRegion($region);

            $manager->persist($accommodation);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['accommodation'];
    }
}
