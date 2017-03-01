<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccountLoginSuccess()
    {
        $this->visitRoute('account.login')
            ->see('Login')
            ->type('anggadarkprince@gmail.com', 'email')
            ->type('angga1234', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs(route('account.show', ['anggadarkprince']));

        $this->action('post', 'Auth\LoginController@logout')
            ->isRedirect(route('index'));
    }

    public function testAccountLoginWrongCredentials()
    {
        $this->visitRoute('account.login')
            ->see('Login')
            ->type('anggadarkprince@gmail.com', 'email')
            ->type('i do not know the password', 'password')
            ->press('Login')
            ->seePageIs(route('account.login'))
            ->see('credentials do not match');

        $this->visitRoute('account.login')
            ->see('Login')
            ->type('i do not now the email as well', 'email')
            ->type('i do not know the password', 'password')
            ->press('Login')
            ->seePageIs(route('account.login'))
            ->see('credentials do not match');
    }
}
