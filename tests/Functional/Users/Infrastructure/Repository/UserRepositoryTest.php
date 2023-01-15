<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    private Generator $faker;
    private UserRepository $repository;
    private AbstractDatabaseTool $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository   = static::getContainer()->get(UserRepository::class);
        $this->faker        = Factory::create();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function test_user_added_to_db_successfully(): void
    {
        $email      = $this->faker->email();
        $password   = $this->faker->password();

        $user = (new UserFactory())->create($email, $password);

        $this->repository->add($user);

        /** @var User $userFromDb */
        $userFromDb = $this->repository->findByUlid($user->getUlid());

        $this->assertEquals($user->getUlid(), $userFromDb->getUlid());
    }

    public function test_user_exist_in_db(): void
    {
        $executor   = $this->databaseTool->loadFixtures([UserFixture::class]);
        /** @var User $user */
        $user       = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);

        $userInDb   = $this->repository->findByUlid($user->getUlid());

        $this->assertEquals($user->getUlid(), $userInDb->getUlid());
    }
}
