<?php

namespace Tests\Browser;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $this->browse(function ($browser) {
            Mail::fake();
            $browser->visitRoute('account.register')
                ->type('name', 'Angga Ari')
                ->type('email', 'angga.aw92@gmail.com')
                ->type('username', 'anggaari')
                ->type('contact', '085655479868')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register')
                ->doesntExpectEvents(Registered::class)
                ->seeInDatabase('users', [
                    'name' => 'Angga Ari',
                    'username' => 'anggaari',
                    'email' => 'angga.aw92@gmail.com',
                ])
                ->seePageIs(route('account.login'))
                ->see('We sent activation code. Please check your mail');
        });
    }
}
