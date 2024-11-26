<?php

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class HighLevelArchitecture
{
    public function test_core_only_depends_on_core(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core'),
                Selector::inNamespace('Doctrine\ORM'),
                Selector::inNamespace('Brick\DateTime')
            )
            ->because('core should not be polluted by view or depencency specific implementations.');
    }

    public function test_infrastructure_only_depend_on_itself_and_core(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Infrasructure'))
            ->canOnlyDependOn()->classes(Selector::inNamespace('App\Core'), Selector::inNamespace('App\Infrasructure'))
            ->because('should not be view specific.');
    }
}
