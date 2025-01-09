<?php

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class NamingConventions
{
    public function test_controllers_have_suffix(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::appliesAttribute('Symfony\Component\Routing\Attribute\Route'))
            ->shouldBeNamed('/\w+Controller$/', regex: true)
            ->because('controllers must use suffix.');
    }

    public function test_forms_have_suffix(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::extends('Symfony\Component\Form\AbstractType'))
            ->shouldBeNamed('/\w+Form$/', regex: true)
            ->because('form types must use `Form` suffix.');
    }

    public function test_events_have_no_suffix(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Core\**\Event\**'))
            ->shouldBeNamed('/.*(?<!Event)$/', regex: true)
            ->because('events must not use suffix.');
    }
}
