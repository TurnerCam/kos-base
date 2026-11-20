<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The environment info panel: server details (PHP, Laravel, database, git commit, package
 * versions) shown on the login page outside production, and at /devinfo for superusers only.
 *
 * Why: testers need to see which server they are on, but production must not show its versions
 * to the public, and the details must never break the login page.
 */
final class DevInfoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Role id 1 is the superuser role; claim it so other roles never get it.
        $role = new Role(['name' => 'Superuser', 'description' => '']);
        $role->id = 1;
        $role->save();
    }

    /**
     * Outside production the login page shows the panel.
     *
     * Expects: the panel and the Laravel version appear on /login.
     */
    public function test_the_login_page_shows_the_panel_outside_production(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('id="environment-info"', false)
            ->assertSee('Laravel '.app()->version());
    }

    /**
     * Production must not tell the public what versions it runs.
     *
     * Expects: no panel on /login when APP_ENV is production.
     */
    public function test_the_login_page_hides_the_panel_in_production(): void
    {
        $this->app['env'] = 'production';
        config(['app.env' => 'production']);

        // Production redirects plain http to https, so ask over https.
        $this->get('https://localhost/login')
            ->assertOk()
            ->assertDontSee('id="environment-info"', false);
    }

    /**
     * A broken database must not lock everyone out of the login page.
     *
     * Expects: /login still loads, and the database row reads "unavailable".
     */
    public function test_the_login_page_still_loads_when_the_database_is_down(): void
    {
        config(['database.connections.broken' => ['driver' => 'mysql', 'host' => '127.0.0.1', 'port' => 1, 'database' => 'none', 'username' => 'none', 'password' => '']]);
        $working = config('database.default');
        config(['database.default' => 'broken']);
        DB::purge('broken');

        $response = $this->get('/login');

        // Put the real database back so the test's own clean-up can roll back.
        config(['database.default' => $working]);

        $response->assertOk()
            ->assertSee('id="environment-info"', false)
            ->assertSee('unavailable');
    }

    /**
     * Expects: a superuser can open /devinfo and sees the server details.
     */
    public function test_a_superuser_can_open_devinfo(): void
    {
        $this->actingAs($this->superuser())->get('/devinfo')
            ->assertOk()
            ->assertSee('laravel/framework')
            ->assertSee(PHP_VERSION);
    }

    /**
     * Superuser only: no ordinary member, and no role permission, opens /devinfo.
     *
     * Expects: 403 for a plain member and for a member whose role has every admin permission.
     */
    public function test_other_members_are_refused_devinfo(): void
    {
        $this->actingAs($this->member())->get('/devinfo')->assertForbidden();

        $admin = $this->member();
        $role = Role::query()->create(['name' => 'admin', 'description' => '']);
        foreach (['users', 'roles', 'reports', 'keys', 'gatekeepers', 'teams'] as $object) {
            RolePermission::query()->create(['role_id' => $role->id, 'object' => $object, 'operation' => 'manage']);
        }
        UserRole::query()->create(['user_id' => $admin->id, 'role_id' => $role->id]);

        $this->actingAs($admin)->get('/devinfo')->assertForbidden();
    }

    /**
     * Expects: a visitor who is not logged in is sent to the login page.
     */
    public function test_a_guest_is_sent_to_login(): void
    {
        $this->get('/devinfo')->assertRedirect('/login');
    }

    private function member(): User
    {
        $user = User::factory()->active()->create();
        UserStatus::query()->create(['user_id' => $user->id, 'status' => UserStatus::STATUS_ACTIVE, 'updated_by' => 0]);

        return $user;
    }

    private function superuser(): User
    {
        $user = $this->member();
        UserRole::query()->create(['user_id' => $user->id, 'role_id' => 1]);

        return $user;
    }
}
