<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeRouteTest extends BrowserKitTestCase
{
    /**
     * A basic functional if home links.
     *
     * @return void
     */
    public function testIndex()
    {
        // visit root domain the show the tag title Showcase.dev
        $this->visit('/')
            ->see('Showcase.dev')
            ->see(date('Y').' Showcase.dev all rights reserved');

        // visit link from index that Discover all portfolio
        $this->visit('/')
            ->click('Discover')
            ->seePageIs(route('page.explore'));

        // visit about link then should pointing about route
        $this->visit('/')
            ->click('About')
            ->seePageIs(route('page.about'));

        // check help route as well
        $this->visit('/')
            ->click('Help')
            ->seePageIs(route('page.help'));

        // visit login link
        $this->visit('/')
            ->click('Login')
            ->seePageIs(route('account.login'));

        // register as well
        $this->visit('/')
            ->click('Register')
            ->seePageIs(route('account.register'));

        // hidden location expect json contain encryption
        $this->visit('/secret')
            ->shouldReturnJson()
            ->seeJsonStructure([
                'data',
                'encrypt',
                'decrypt'
            ]);
    }

    /**
     * Check contain of about page.
     */
    public function testAbout()
    {
        $this->visitRoute('page.about')
            ->see('Crafted by')
            ->see('@anggadarkprince');
    }

    /**
     * Make sure the right content for help page.
     */
    public function testHelp()
    {
        $this->visitRoute('page.help')
            ->see('Ask question?')
            ->see('+Contact Me');
    }

    /**
     * Test if github link is correct
     */
    public function testGithub()
    {
        $this->visit('/')
            ->seeRouteIs('index')
            ->seeElement('a', ['href' => 'https://github.com/anggadarkprince/showcase']);
    }

    /**
     * Test title of page explore
     */
    public function testExplore()
    {
        $this->visitRoute('page.explore')
            ->see('Discover Masterpiece');
    }

    public function testCategory()
    {
        $this->visit('/explore')
            ->click('Education')
            ->seePageIs(route('portfolio.search.category', ['education-2']));
    }
}
