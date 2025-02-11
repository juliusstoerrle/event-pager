<?php

declare(strict_types= 1);

namespace App\Tests\Core\UserManagement\Application;

use App\Core\UserManagement\Application\AddUserHandler;
use App\Core\UserManagement\Command\AddUser;
use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Entity\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

#[CoversClass(AddUser::class)]
#[CoversClass(AddUserHandler::class)]
#[Group('unit')]
final class AddUserHandlerTest extends TestCase
{
    public function testAddUserCommand(): void
    {
        $repository = self::createMock(UserRepository::class);

        $repository->expects(self::once())->method('save')
            ->with(self::callback(function ($value) {
                return $value instanceof User
                    && $value->getUsername() === 'test-user'
                    && $value->getDisplayName() === 'Test User'
                    && $value->getPassword() !== 'secure-password'; // Password should be hashed
            }));

        $sut = new AddUserHandler($repository, new UserPasswordHasher(new PasswordHasherFactory([User::class => ['algorithm' => 'auto']])));
        $command = AddUser::with(
            'test-user',
            'secure-password',
            'Test User'
        );
        $sut->__invoke($command);
    }
}