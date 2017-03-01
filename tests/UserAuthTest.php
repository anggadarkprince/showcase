<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Valid credential authorize account to enter dashboard.
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

    /**
     * Invalid credentials combination.
     */
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

    /**
     * User login a pending account,
     * tell them to activate via email first.
     */
    public function testLoginWithStatusPending()
    {
        $user = factory(App\User::class)->create([
            'status' => 'pending',
        ]);

        $this->visitRoute('account.login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs(route('account.login'))
            ->see('Please activate your account first')
            ->see('Inactive account');
    }

    /**
     * User login a suspended account,
     * tell them to contact support for more information about their account status.
     */
    public function testLoginWithStatusSuspended()
    {
        $user = factory(App\User::class)->create([
            'status' => 'suspended',
        ]);

        $this->visitRoute('account.login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs(route('account.login'))
            ->see('Your account was suspended')
            ->see('Suspended account');
    }
}
