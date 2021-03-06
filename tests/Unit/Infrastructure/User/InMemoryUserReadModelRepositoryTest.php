<?php
declare(strict_types=1);

namespace TSwiackiewicz\AwesomeApp\Tests\Unit\Infrastructure\User;

use TSwiackiewicz\AwesomeApp\Infrastructure\{
    InMemoryStorage, User\InMemoryUserReadModelRepository
};
use TSwiackiewicz\AwesomeApp\ReadModel\User\{
    UserDTO, UserQuery
};
use TSwiackiewicz\AwesomeApp\SharedKernel\User\UserId;
use TSwiackiewicz\AwesomeApp\Tests\Unit\UserBaseTestCase;

/**
 * Class InMemoryUserReadModelRepositoryTest
 * @package TSwiackiewicz\AwesomeApp\Tests\Unit\Infrastructure\User
 *
 * @@coversDefaultClass  InMemoryUserReadModelRepository
 */
class InMemoryUserReadModelRepositoryTest extends UserBaseTestCase
{
    private const USER_STORAGE_TYPE = 'user';

    /**
     * @var InMemoryUserReadModelRepository
     */
    private $repository;

    /**
     * @test
     */
    public function shouldFindUserById(): void
    {
        $user = $this->repository->findById(UserId::fromInt(1));

        self::assertInstanceOf(UserDTO::class, $user);
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenUserNotFoundById(): void
    {
        $user = $this->repository->findById(UserId::fromInt(123));

        self::assertNull($user);
    }

    /**
     * @test
     */
    public function shouldFindUsersByQuery(): void
    {
        $users = $this->repository->findByQuery(
            new UserQuery(true, true)
        );

        self::assertCount(1, $users);
        self::assertInstanceOf(UserDTO::class, $users[0]);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenUsersNotFoundByQuery(): void
    {
        $users = $this->repository->findByQuery(
            new UserQuery(false, false)
        );

        self::assertEquals([], $users);
    }

    /**
     * @test
     */
    public function shouldReturnAllUsers(): void
    {
        $users = $this->repository->getUsers();

        self::assertCount(3, $users);
        foreach ($users as $user) {
            self::assertInstanceOf(UserDTO::class, $user);
        }
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenNoUsersDefined(): void
    {
        InMemoryStorage::clear(self::USER_STORAGE_TYPE);

        $users = $this->repository->getUsers();

        self::assertEquals([], $users);
    }

    /**
     * Setup fixtures
     */
    protected function setUp(): void
    {
        InMemoryStorage::clear();

        InMemoryStorage::save(
            self::USER_STORAGE_TYPE,
            [
                'id' => 1,
                'login' => 'registered_user@domain.com',
                'password' => 'test_password',
                'active' => false
            ]
        );
        InMemoryStorage::save(
            self::USER_STORAGE_TYPE,
            [
                'id' => 2,
                'login' => 'active_enabled_user@domain.com',
                'password' => 'test_password',
                'active' => true,
                'enabled' => true
            ]
        );
        InMemoryStorage::save(
            self::USER_STORAGE_TYPE,
            [
                'id' => 3,
                'login' => 'active_disabled_user@domain.com',
                'password' => 'test_password',
                'active' => true,
                'enabled' => false
            ]
        );

        $this->repository = new InMemoryUserReadModelRepository();
    }
}