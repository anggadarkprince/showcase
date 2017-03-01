<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeRouteTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit('/')
            ->see('Showcase.dev')
            ->see(date('Y').' Showcase.dev all rights reserved');

        $this->visit('/')
            ->click('Discover')
            ->seePageIs(route('page.explore'));

        $this->visit('/')
            ->click('About')
            ->seePageIs(route('page.about'));

        $this->visit('/')
            ->click('Help')
            ->seePageIs(route('page.help'));

        $this->visit('/')
            ->click('Login')
            ->seePageIs(route('account.login'));

        $this->visit('/')
            ->click('Register')
            ->seePageIs(route('account.register'));

        $this->visit('/secret')
            ->seeJsonStructure([
                'data',
                'encrypt',
                'decrypt'
            ]);
    }

    public function testAbout()
    {
        $this->visitRoute('page.about')
            ->see('Crafted by')
            ->see('@anggadarkprince');
    }

    public function testHelp()
    {
        $this->visitRoute('page.help')
            ->see('Ask question?')
            ->see('+Contact Me');
    }

    public function testGithub()
    {
        $this->visit('/')
            ->seeRouteIs('index')
            ->seeElement('a', ['href' => 'https://github.com/anggadarkprince/showcase']);
    }

    public function testExplore()
    {
        $this->visitRoute('page.explore')
            ->see('Discover Masterpiece');
    }

    public function testAccountProfileByUsername()
    {
        $this->visitRoute('profile.show', ['user' => 'anggadarkprince'])
            ->see('Angga Ari Wijaya')
            ->see('@anggadarkprince')
            ->see('Showcases');
    }
}
