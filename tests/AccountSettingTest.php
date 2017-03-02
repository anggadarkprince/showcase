<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountSettingTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp()
    {
        parent::setUp();

        // see if setting form show correct data as logged user
        $this->user = factory(\App\User::class)->create([
            'password' => bcrypt('secret')
        ]);

        $this->actingAs($this->user)
            ->visit(route('account.settings', [
                'user' => $this->user->username
            ]));
    }

    /**
     * Normal update setting without change new password.
     */
    public function testUpdateSettingWithoutChangePassword()
    {
        $this->see('Settings')
            ->see('Change user account information')
            ->seeElement('input[name=name]', ['value' => $this->user->name])
            ->seeElement('input[name=username]', ['value' => $this->user->username])
            ->seeInElement('textarea[name=about]', $this->user->about)
            ->seeElement('input[name=birthday]', ['value' => $this->user->birthday->format('Y-m-d')])
            ->seeElement('input[name=email]', ['value' => $this->user->email])
            ->seeElement('input[name=contact]', ['value' => $this->user->contact])
            ->seeElement('input[name=location]', ['value' => $this->user->location]);

        if ($this->user->gender == 'male') {
            $this->seeElement('input[id=male]', ['checked' => 'checked']);
            $this->dontSeeElement('input[id=female]', ['checked' => 'checked']);
        } else {
            $this->seeElement('input[id=female]', ['checked' => 'checked']);
            $this->dontSeeElement('input[id=male]', ['checked' => 'checked']);
        }

        // try to make changes
        $this->type('Angga', 'name')
            //->type('angga92', '#username')
            ->type('This is my profile', 'about')
            ->type('1992-05-26', 'birthday')
            ->type('angga@gmail.com', 'email')
            ->type('0856554', 'contact')
            ->type('Gresik, Indonesia', 'location')
            ->type('secret', 'password')
            ->press('Save Settings')
            //->assertRedirectedTo(route('account.settings.store', [$user->username]))
            ->seePageIs(route('account.settings', [$this->user->username]))
            ->see('Setting was updated successfully');
    }

    /**
     * Test save setting without put current password.
     */
    public function testSaveSettingWithoutPassword()
    {
        $this->visit(route('account.settings', [
            'user' => $this->user->username
        ]))
            ->press('Save Settings')
            ->see('The password is needed to update settings.');
    }

    /**
     * Test what happen when new password is not confirmed (blank) or mismatch.
     */
    public function testChangePasswordWithoutConfirmed()
    {
        $this->visit(route('account.settings', [
            'user' => $this->user->username
        ]))
            ->type('secret', 'password')
            ->type('new secret', 'password_new')
            ->type('no secret', 'password_new_confirmation') // unconfirmed or mismatch
            ->press('Save Settings')
            ->see(trans('validation.confirmed', ['attribute' => str_replace('_', ' ', 'password_new')]));
    }

    /**
     * Test some fields are not empty.
     */
    public function testEmptyRequiredField()
    {
        $this->visit(route('account.settings', [
            'user' => $this->user->username
        ]))
            ->type('', 'name')
            ->type('', 'username')
            ->type('', 'email')
            ->type('', 'about')
            ->type('', 'birthday')
            ->type('', 'location')
            ->type('', 'contact')
            ->type('secret', 'password')
            ->press('Save Settings')
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see(trans('validation.required', ['attribute' => 'username']))
            ->see(trans('validation.custom.email.required'))
            ->see(trans('validation.required', ['attribute' => 'about']))
            ->see(trans('validation.required', ['attribute' => 'birthday']))
            ->see(trans('validation.required', ['attribute' => 'location']))
            ->see(trans('validation.required', ['attribute' => 'contact']));
    }

    /**
     * Test limit max of characters length.
     */
    public function testCharacterLimitation()
    {
        $this->visit(route('account.settings', [
            'user' => $this->user->username
        ]))
            ->type(str_random(256), 'name')
            ->type(str_random(21), 'username')
            ->type(str_random(101), 'email')
            ->type(str_random(501), 'about')
            ->type(str_random(256), 'location')
            ->type(str_random(256), 'contact')
            ->type('secret', 'password')
            ->type(str_random(21), 'password_new')
            ->type(str_random(21), 'password_new_confirmation')
            ->press('Save Settings')
            ->see(trans('validation.max.string', ['attribute' => 'name', 'max' => 255]))
            ->see(trans('validation.regex', ['attribute' => 'username']))
            ->see(trans('validation.max.string', ['attribute' => trans('validation.attributes.email'), 'max' => 100]))
            ->see(trans('validation.max.string', ['attribute' => 'about', 'max' => 500]))
            ->see(trans('validation.max.string', ['attribute' => 'location', 'max' => 255]))
            ->see(trans('validation.max.string', ['attribute' => 'contact', 'max' => 255]))
            ->see(trans('validation.max.string', ['attribute' => str_replace('_', ' ', 'password_new'), 'max' => 20]))
            ->see(trans('validation.max.string', ['attribute' => str_replace('_', ' ', 'password_new_confirmation'), 'max' => 20]));
    }

    /**
     * Test username pattern, must allow contain alpha-numeric, dash, underscore and dot only.
     * combination is okay, and it's not require to include all allowed characters.
     */
    public function testInvalidUsername()
    {
        // username pattern invalid (too short, less than 5) and email invalid format
        $this->type('an', 'username')
            ->type('angga_email23.com', 'email')
            ->press('Save Settings')
            ->see(trans('validation.regex', ['attribute' => 'username']))
            ->see(trans('validation.email', ['attribute' => Lang::get('validation.attributes.email')]));

        // username contains invalid character (excluding alphabet, underscore, dash, dot and number)
        $this->type('angga!##%^&$', 'username')
            ->press('Save Settings')
            ->see(trans('validation.regex', ['attribute' => 'username']));

        // user was registered before
        $this->type('anggadarkprince@gmail.com', 'email')
            ->press('Save Settings')
            ->see(trans('validation.unique', ['attribute' => Lang::get('validation.attributes.email')]));

        // example of valid username
        $this->type('anggaari', 'username')
            ->press('Save Settings')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('angga.ari', 'username')
            ->press('Save Settings')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('angga_ari92', 'username')
            ->press('Save Settings')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));

        $this->type('Angga-ari.92_w', 'username')
            ->press('Save Settings')
            ->dontSee(trans('validation.regex', ['attribute' => 'username']));
    }

    /**
     * Test user birthday format, must a valid date following Y-m-d format
     */
    public function testInvalidBirthday()
    {
        // random text
        $this->type('sag4654hgd', 'birthday')
            ->press('Save Settings')
            ->see(trans('validation.date_format', ['attribute' => 'birthday', 'format' => 'Y-m-d']));

        // invalid d-m-Y
        $this->type('23-10-2010', 'birthday')
            ->press('Save Settings')
            ->see(trans('validation.date_format', ['attribute' => 'birthday', 'format' => 'Y-m-d']));

        // invalid m-d-Y
        $this->type('01-25-2010', 'birthday')
            ->press('Save Settings')
            ->see(trans('validation.date_format', ['attribute' => 'birthday', 'format' => 'Y-m-d']));

        // valid Y-m-d
        $this->type('2010-08-12', 'birthday')
            ->press('Save Settings')
            ->dontSee(trans('validation.date_format', ['attribute' => 'birthday', 'format' => 'Y-m-d']));
    }
}
