<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;

class PublicProfileTest extends BrowserKitTestCase
{

    /**
     * Test public portfolio profile
     */
    public function testAccountProfileByUsername()
    {
        Notification::fake();

        // visit an user
        $user = \App\User::find(1);
        $this->visitRoute('profile.show', ['user' => $user->username])
            ->see($user->name)
            ->see('@' . $user->username)
            ->see($user->location)
            ->see($user->about)
            ->see($user->email)
            ->see($user->contact)
            ->see($user->birthday->format('d F Y'))
            ->see($user->gender)
            ->see('Showcases');

        // check if they have portfolio, if they have, check content of portfolio
        $portfolio = $user->portfolios()->latest('date')->first();

        if ($portfolio->count() > 0) {
            $this->see($portfolio->title);
            $this->see($portfolio->company);
            $this->see($portfolio->date->diffForHumans());

            // try to see the detail
            $this->click($portfolio->title)
                ->seePageIs(route('profile.portfolio.show', [$user->username, str_slug($portfolio->title) . '-' . $portfolio->id]))
                ->see($portfolio->title)
                ->see($portfolio->view + 1)
                ->see($portfolio->description)
                ->see('SCREENSHOTS')
                ->assertResponseOk();
        }
    }

    /**
     * Test if account profile is not found
     */
    public function testAccountProfileNotFound()
    {
        $this->get(route('profile.show', ['user' => 'unknown_username']))
            ->see('Page Not Found')
            ->assertResponseStatus(404);
    }
}
