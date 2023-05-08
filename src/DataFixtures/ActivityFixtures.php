<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Region;
use App\Repository\RegionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $repo = $manager->getRepository(Region::class);
        $activitiesData = [
            // Monuments
            [
                'name' => 'Amphitheatre of El Jem',
                'description' => 'A well-preserved Roman amphitheater, a UNESCO World Heritage site.',
                'region' => 'Mahdia',
                'latitude' => 35.2931,
                'longitude' => 10.7111,
            ],
            [
                'name' => 'Bardo National Museum',
                'description' => 'A museum housing an extensive collection of Roman mosaics and artifacts from ancient Tunisia.',
                'region' => 'Tunis',
                'latitude' => 36.8061,
                'longitude' => 10.1297,
            ],
            // ...
            // Fun activities
            [
                'name' => 'Sahara Desert Adventures',
                'description' => 'Thrilling desert excursions on camelback, quad bikes, or 4x4 vehicles.',
                'region' => 'Kebili',
                'latitude' => 33.4522,
                'longitude' => 9.0201,
            ],
            [
                'name' => 'Pirate Ship Hammamet',
                'description' => 'An awesome pirate-themed boat tour with music, entertainment, and swimming opportunities.',
                'region' => 'Hammamet',
                'latitude' => 36.3994,
                'longitude' => 10.6189,
            ],
            // ...
        ];

        foreach ($activitiesData as $activityData) {
            $activity = new Activity();
            $activity->setName($activityData['name']);
            $activity->setDescription($activityData['description']);
            $activity->setLatitude($activityData['latitude']);

            $region = $repo->findOneBy(['name' => $activityData['region']]);
            $activity->setRegion($region);

            $activity->setLongitude($activityData['longitude']);
            $manager->persist($activity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['activity'];
    }
}
