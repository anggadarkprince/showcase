<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountDashboardTest extends TestCase
{
    /**
     * Test if user visit account sub domain then redirect to their dashboard.
     */
    public function testDashboardAfterLogin()
    {
        $user = factory(User::class)->create();

        // visit http://account.domain.dev/username should show the dashboard
        $this->actingAs($user)
            ->visitRoute('account.show', [$user->username])
            ->see($user->name)// show the name logged user
            ->see('Showcase Today')// only in dashboard page
            ->see('Logout')// indicate after login
            ->see('My Portfolio')// in account page only
            ->see('Create Portfolio') // account dashboard
            ->assertResponseOk(); // all good
    }

    /**
     * Check if prefix username in account url is correct, if not then redirect
     * to the correct one or block the request.
     * Make sure user redirected to their dashboard after logged in.
     */
    public function testRedirectVisitAccount()
    {
        $user = factory(User::class)->create();

        // visit http://account.domain.dev should redirect to http://account.domain.dev/username
        $this->actingAs($user)
            ->visitRoute('account.profile')
            ->seePageIs(route('account.show', [$user->username]));

        // check if prefix logged user is different with current session the return unauthorized page
        $response = $this->call('GET', route('account.show', ['lyric61']));
        $this->assertEquals(403, $response->status()); // alternative
        $this->assertResponseStatus(403);

        // check if user prefix is not exist in database, then return 404
        $this->get(route('account.show', ['username_does_not_exist']))
            ->see('Page Not Found')
            ->assertResponseStatus(404);
    }
}
