<?php

namespace Tests\Feature\Http\Controllers\UsersController;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Saving the member edit page (Members > Edit, PUT /users/{id}) with a blank street address, city,
 * province or postal code must be refused with a message, not crash.
 *
 * The four columns are NOT NULL in the database, and blank form fields reach the controller as
 * null. Before this was fixed, the controller did not check them, so clearing one gave the admin a
 * server error (500) on MySQL. The member's own profile page already required them. Added with the
 * Laravel 9 to 13 upgrade (November 2026).
 *
 * Saving with all fields filled in is covered by ActionPermissionsTest ("edit a member").
 */
final class UpdateMemberTest extends TestCase
{
    use RefreshDatabase;

    // Someone allowed to manage members, and a member with a full address to edit.
    private User $admin;

    private User $member;

    protected function setUp(): void
    {
        parent::setUp();
        $role = Role::query()->create(['name' => 'test-admin', 'description' => '']);
        RolePermission::query()->create(['role_id' => $role->id, 'object' => 'users', 'operation' => 'manage']);
        $this->admin = User::factory()->create(['status' => UserStatus::STATUS_ACTIVE]);
        $this->admin->roles(true)->attach($role);
        $this->member = User::factory()->create([
            'address' => '1 Test St', 'city' => 'Kitchener', 'province' => 'Ontario', 'postal' => 'N2G 1A1',
        ]);
    }

    // Each address field, and a value that is only spaces (trimmed to blank, so also null).
    public static function provideBlankAddressFields(): array
    {
        return [
            'street address' => ['address', ''],
            'city' => ['city', ''],
            'province' => ['province', ''],
            'postal code' => ['postal', ''],
            'postal code of only spaces' => ['postal', '   '],
        ];
    }

    /**
     * An admin saves the edit page with one address field blank. The page comes back with an error
     * on that field, and the member's stored address is unchanged.
     *
     * Why: the database refuses a blank address, so without this check the save fails with a
     * server error and the admin gets no hint which field is the problem.
     */
    #[DataProvider('provideBlankAddressFields')]
    public function test_saving_a_member_with_a_blank_address_field_is_refused(string $field, string $value): void
    {
        $form = [
            'first_name' => $this->member->first_name, 'last_name' => $this->member->last_name,
            'first_preferred' => $this->member->first_preferred, 'last_preferred' => $this->member->last_preferred,
            'email' => $this->member->email,
            'address' => '1 Test St', 'city' => 'Kitchener', 'province' => 'Ontario', 'postal' => 'N2G 1A1',
        ];
        $form[$field] = $value;

        $this->actingAs($this->admin)
            ->from("/users/{$this->member->id}/edit")
            ->put("/users/{$this->member->id}", $form)
            ->assertRedirect("/users/{$this->member->id}/edit")
            ->assertSessionHasErrors($field);

        $this->member->refresh();
        $this->assertSame(['1 Test St', 'Kitchener', 'Ontario', 'N2G 1A1'],
            [$this->member->address, $this->member->city, $this->member->province, $this->member->postal]);
    }
}
