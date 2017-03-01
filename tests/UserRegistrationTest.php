<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class UserRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    /**
     * Set default user for mocking registered user when activating account.
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create([
            'status' => 'pending',
        ]);
        $this->seeInDatabase('users', [
            'email' => $this->user->email,
            'status' => 'pending'
        ]);
    }

    /**
     * Check default registered user.
     *
     * @return void
     */
    public function testDefaultUser()
    {
        $this->seeInDatabase('users', [
            'email' => 'anggadarkprince@gmail.com'
        ]);
    }

    /**
     * Normal and valid input which satisfy form validation.
     */
    public function testRegisterValidUser()
    {
        Mail::fake();
        $this->visitRoute('account.register')
            ->type('Angga Ari', 'name')
            ->type('angga.aw92@gmail.com', 'email')
            ->type('anggaari', 'username')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register')
            ->doesntExpectEvents(\Illuminate\Auth\Events\Registered::class)
            ->seeInDatabase('users', [
                'name' => 'Angga Ari',
                'username' => 'anggaari',
                'email' => 'angga.aw92@gmail.com',
            ])
            ->seePageIs(route('account.login'))
            ->see('We sent activation code. Please check your mail');
    }

    /**
     * Sets of invalid input combination when registering an account.
     */
    public function testRegisteredInvalidInput()
    {
        // all field empty
        $this->visitRoute('account.register')
            ->press('Register')
            ->seePageIs(route('account.register'))
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see(trans('validation.required', ['attribute' => 'username']))
            ->see(trans('validation.custom.email.required', ['attribute' => 'email']))
            ->see(trans('validation.required', ['attribute' => 'password']));

        // input over the limit or least than should be.
        $this->type(str_random(101), 'name')
            ->type(str_random(51), 'username')
            ->type(str_random(101), 'email')
            ->type('1234', 'password')
            ->press('Register')
            ->see(trans('validation.max.string', ['attribute' => 'name', 'max' => 100]))
            ->see(trans('validation.max.string', ['attribute' => 'username', 'max' => 20]))
            ->see(trans('validation.max.string', ['attribute' => Lang::get('validation.attributes.email'), 'max' => 100]))
            ->see(trans('validation.min.string', ['attribute' => 'password', 'min' => 6]));

        // username must match pattern /[a-zA-Z0-9-_\.]{5,20}/
        // username pattern invalid (too short, less than 5) and email invalid format
        $this->type('an', 'username')
            ->type('angga_email23.com', 'email')
            ->press('Register')
            ->see(trans('validation.regex', ['attribute' => 'username']))
            ->see(trans('validation.email', ['attribute' => Lang::get('validation.attributes.email')]));

        // username contains invalid character (excluding alphabet, underscore, dash, dot and number)
        $this->type('angga!##%^&$', 'username')
            ->press('Register')
            ->see(trans('validation.regex', ['attribute' => 'username']));

        // user was registered before
        $this->type('anggadarkprince@gmail.com', 'email')
            ->press('Register')
            ->see(trans('validation.unique', ['attribute' => Lang::get('validation.attributes.email')]));

        // example of valid username
        $this->type('anggaari', 'username')
            ->press('Register')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('angga.ari', 'username')
            ->press('Register')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('angga_ari92', 'username')
            ->press('Register')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('Angga-ari.92_w', 'username')
            ->press('Register')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        // password mismatch
        $this->type('secret', 'password')
            ->type('another secret', 'password_confirmation')
            ->press('Register')
            ->see(trans('validation.confirmed', ['attribute' => 'password']));
    }

    /**
     * Normal flow, user activate their account from link was sent in email.
     */
    public function testUserActivationSuccess()
    {
        // prepare user mockup in setUp function above

        $response = $this->call('get', "http://account.laravel.dev/activation/{$this->user->token}");
        //$this->action('get', 'Auth\RegisterController@userActivation', ['token' => $user->token]);
        $this->seeStatusCode(302); // should be return redirect code
        $response->isRedirect(route('account.login')); // then redirect to route
        $this->assertRedirectedToAction('Auth\LoginController@login'); // that route call this action in controller

        $crawler = $this->followRedirects(); // follow redirect page and load
        $crawler->see('User active successfully.'); // see content of the page (login)

        // make sure users who activate their account was updated
        $this->seeInDatabase('users', [
            'email' => $this->user->email,
            'status' => 'activated'
        ]);
    }

    /**
     * User is already activated before and try to activate again.
     */
    public function testUserActivationAlready()
    {
        // make sure user is already activated
        \App\User::find($this->user->id)->update(['status' => 'activated']);
        $this->seeInDatabase('users', [
            'email' => $this->user->email,
            'status' => 'activated'
        ]);

        $response = $this->action('get', 'Auth\RegisterController@userActivation', ['token' => $this->user->token]);
        $this->seeStatusCode(302); // should be return redirect code
        $response->isRedirect(route('account.login')); // then redirect to route
        $this->assertRedirectedToAction('Auth\LoginController@login'); // that route call this action in controller

        $crawler = $this->followRedirects(); // follow redirect page and load
        $crawler->see('User is already activated.'); // see content of the page (login)

        // make sure users still activated
        $this->seeInDatabase('users', [
            'email' => $this->user->email,
            'status' => 'activated'
        ]);
    }

    /**
     * User tries activate their account with invalid token,
     * or someone put anything in activation url
     */
    public function testUserActivationTokenNotFound()
    {
        $response = $this->action('get', 'Auth\RegisterController@userActivation', ['token' => '363grg-invalid-token-34534']);
        $response->isRedirect(route('account.login'));
        $this->followRedirects()
            ->see('Your token is invalid');
    }
}
