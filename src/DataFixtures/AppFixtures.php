<?php

namespace App\DataFixtures;
use App\Entity\Company;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use App\Entity\JobApplication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $companies = [];
        $jobOffers = [];
        $candidates = [];


        for ($i = 0; $i < 5; $i++) {
            $company = new Company();
            $company->setPhoneNumber($faker->phoneNumber);
            $company->setName($faker->company);
            $company->setDescription($faker->paragraph);
            $company->setWebsite($faker->url);

            $manager->persist($company);
            $companies[] = $company;
        }


        for ($i = 0; $i < 15; $i++) {
            $offer = new JobOffer();
            $offer->setTitle($faker->jobTitle);
            $offer->setDescription($faker->paragraph(5));
            $offer->setLocation($faker->city);
            $offer->setContractType($faker->randomElement(['Full-time', 'Part-time', 'Internship']));
            $offer->setSalary($faker->randomFloat(2, 30000, 100000)); // garanti non-null
            $offer->setPublishedAt($faker->dateTimeBetween('-4 months', 'now'));
            $offer->setCompany($faker->randomElement($companies));

            $manager->persist($offer);
            $jobOffers[] = $offer;
        }


        for ($i = 0; $i < 20; $i++) {
            $candidate = new Candidate();
            $candidate->setFirstName($faker->firstName);
            $candidate->setLastName($faker->lastName);
            $candidate->setEmail($faker->unique()->safeEmail);
            $candidate->setBio($faker->paragraph(3));
            $candidate->setPhoneNumber($faker->phoneNumber);
            $candidate->setRegistrationDate($faker->dateTimeBetween('-1 year', 'now'));

            $manager->persist($candidate);
            $candidates[] = $candidate;
        }


        for ($i = 0; $i < 50; $i++) {
            $application = new JobApplication();
            $application->setAppliedAt($faker->dateTimeBetween('-3 months', 'now'));
            $application->setStatus($faker->randomElement(['pending', 'accepted', 'rejected']));
            $application->setCoverLetter($faker->paragraph(4));

            $application->setCandidate($faker->randomElement($candidates));
            $application->setJobOffer($faker->randomElement($jobOffers));

            $manager->persist($application);
        }

        $manager->flush();
    }
}
