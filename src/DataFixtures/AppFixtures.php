<?php

namespace App\DataFixtures;

use App\Entity\Bet;
use App\Entity\Game;
use App\Entity\LeaderBoard;
use App\Entity\League;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pokedex;
use App\Entity\Team;
use App\Entity\User;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 12; $i++) {
            $teams1 = new Team();
            $teams1->setName($faker->name)
                ->setLogo($faker->text);

            $manager->persist($teams1);

            $teams2 = new Team();
            $teams2->setName($faker->name)
                ->setLogo($faker->text);

            $manager->persist($teams2);

            $games = new Game();
            $games->setScore1($faker->randomDigit)
                ->setScore2($faker->randomDigit)
                ->setBanner($faker->text)
                ->setDateMatch($faker->dateTime())
                ->setTeamId1($teams1)
                ->setTeamId2($teams2);

            $manager->persist($games);
        }

         for ($i = 0; $i < 9; $i++) {
                $leagues = new League();
                $leagues->setName($faker->name)
                       ->setCodeInvite($faker->uuid);
    
                $manager->persist($leagues);
    
                $users = new User();
                $password = $faker->password(2, 6);
                $users->setLastname($faker->lastName)
                       ->setName($faker->name)
                       ->setEmail($faker->email)
                       ->setPassword($faker->password(2, 6))
                       ->addLeague($leagues);
    
                $manager->persist($users);
    
                $leaderboards = new LeaderBoard();
                $leaderboards->setPosition($faker->randomDigit)
                             ->addUser($users)
                             ->setPoints($faker->randomDigit)
                             ->setNbWin($faker->randomDigit)
                             ->setNbLose($faker->randomDigit);
    
                $manager->persist($leaderboards);
            }
    
            for ($i = 0; $i < 12; $i++) {
                $bets = new Bet();
                $bets->addUser($users)
                ->setGame($games)
                     ->setLeague($leagues)
                     ->setTeam($teams1)
                     ->setIsDraw($faker->boolean);
    
                $manager->persist($bets);
            }


        $manager->flush();
    }
}
