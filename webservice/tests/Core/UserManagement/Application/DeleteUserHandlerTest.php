<?php

declare(strict_types=1);

namespace App\Tests\Core\UserManagement\Application;

use App\Core\UserManagement\Application\DeleteUserHandler;
use App\Core\UserManagement\Command\DeleteUser;
use App\Core\UserManagement\Model\User;
use App\Infrastructure\Repository\UserRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeleteUser::class)]
#[CoversClass(DeleteUserHandler::class)]
#[Group('unit')]
class DeleteUserHandlerTest extends TestCase
{
    public function testDeleteUserCommand(): void
    {
        $repository = self::createMock(UserRepository::class);
        $user = new User();
        $user->setUsername('test-user');

        $repository->expects(self::once())->method('findOneBy')
            ->with(['username' => 'test-user'])
            ->willReturn($user);
        $repository->expects(self::once())->method('delete')
            ->with($user);

        $sut = new DeleteUserHandler($repository);
        $command = DeleteUser::with(
            'test-user'
        );
        $sut->__invoke($command);
    }
}
