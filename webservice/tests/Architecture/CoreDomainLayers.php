<?php

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class CoreDomainLayers
{
    public function test_sendmessage_only_depend_on_lower_levels(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\SendMessage'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core\SendMessage'),
                Selector::inNamespace('App\Core\Bus'),
                Selector::inNamespace('App\Core\Transport'),
                Selector::NOT(Selector::inNamespace('App\Core')) // everything outside the core is handled by rules in HighLevelArchitecture.php
            )
            ->because('to increase maintainability');
    }

    public function test_intelpage_only_depend_on_lower_levels(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\IntelPage'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core\IntelPage'),
                Selector::inNamespace('App\Core\Bus'),
                Selector::inNamespace('App\Core\Transport'),
                Selector::NOT(Selector::inNamespace('App\Core')) // everything outside the core is handled by rules in HighLevelArchitecture.php
            )
            ->because('to increase maintainability');
    }

    public function test_transport_only_depend_on_lower_levels(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\Transport'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core\Transport'),
                Selector::inNamespace('App\Core\Bus'),
                Selector::NOT(Selector::inNamespace('App\Core')) // everything outside the core is handled by rules in HighLevelArchitecture.php
            )
            ->because('to increase maintainability');
    }

    public function test_bus_only_depend_on_itself(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\Bus'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core\Bus'),
                Selector::NOT(Selector::inNamespace('App\Core')) // everything outside the core is handled by rules in HighLevelArchitecture.php
            )
            ->because('to increase maintainability');
    }

    public function test_updatepusher_only_depend_on_itself(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\UpdatePusher'))
            ->canOnlyDependOn()->classes(
                Selector::inNamespace('App\Core\UpdatePusher'),
                Selector::NOT(Selector::inNamespace('App\Core')) // everything outside the core is handled by rules in HighLevelArchitecture.php
            )
            ->because('to increase maintainability');
    }
}
