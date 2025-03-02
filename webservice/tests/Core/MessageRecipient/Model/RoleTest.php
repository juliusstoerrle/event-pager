<?php

declare(strict_types=1);

namespace App\Tests\Core\MessageRecipient\Model;

use App\Core\MessageRecipient\Model\Person;
use App\Core\MessageRecipient\Model\Role;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

#[CoversClass(Role::class)]
#[Small()]
final class RoleTest extends TestCase
{
    /**
     * @return array{0: string, 1: ?Person, 2: ?Ulid}[]
     */
    public static function constructorProvider(): array
    {
        return [
            ['Boss', new Person('Alice'), null],
            ['Responsible', null, new Ulid()],
        ];
    }

    #[DataProvider('constructorProvider')]
    public function testConstructor(string $name, ?Person $person, ?Ulid $id): void
    {
        $role = new Role($name, $person, $id);

        if (null === $id) {
            $role->id->toString();
        } else {
            self::assertSame($id, $role->id);
        }
        self::assertSame($name, $role->getName());
        self::assertSame($person, $role->person);
    }

    /**
     * @return array{0: bool, 1: ?Person}[]
     */
    public static function canResolveProvider(): array
    {
        return [
            [true, new Person('Bob')],
            [false, null],
        ];
    }

    #[DataProvider('canResolveProvider')]
    public function testCanResolve(bool $expected, ?Person $person): void
    {
        $role = new Role('Important', $person);

        self::assertSame($expected, $role->canResolve());
    }

    public function testResolve(): void
    {
        $person = new Person('Eve');
        $role = new Role('Somebody', $person);

        $result = $role->resolve();

        self::assertSame([$person], $result);
    }

    public function testResolveException(): void
    {
        $role = new Role('Nobody', null);

        self::expectException(LogicException::class);

        $role->resolve();
    }

    public function testBindPerson(): void
    {
        $person = new Person('Eve');

        $role = new Role('Role A', null);

        $role->bindPerson($person);

        self::assertSame($person, $role->person);
    }

    public function testRemovePersonAssignment(): void
    {
        $person = new Person('Eve');

        $role = new Role('Role A', $person);
        self::assertSame($person, $role->person);

        $role->bindPerson(null);

        self::assertNull($role->person);
    }
}
