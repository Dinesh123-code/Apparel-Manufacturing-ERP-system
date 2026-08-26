<?php

namespace Tests\Feature;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionBundleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Buyer $buyer;
    private Style $style;
    private SewingLine $line;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user  = User::factory()->create();
        $this->buyer = Buyer::create(['buyer_name' => 'Test Buyer']);
        $this->line  = SewingLine::create(['line_name' => 'Line A']);
        $this->style = Style::create(['buyer_id' => $this->buyer->id, 'style_no' => 'TST-001']);
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'bundle_no'       => 'BND-TEST-001',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'color'           => 'Navy Blue',
            'size'            => 'L',
            'line_id'         => $this->line->id,
            'quantity'        => 100,
            'completed_qty'   => 80,
            'rejected_qty'    => 5,
            'operator_name'   => 'John Smith',
            'production_date' => now()->subDay()->format('Y-m-d'),
            'remarks'         => 'Test bundle',
        ], $overrides);
    }

    /* ------------------------------------------------------------------ */
    /*  Web CRUD Tests                                                       */
    /* ------------------------------------------------------------------ */

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('bundles.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_bundle_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('bundles.index'));
        $response->assertOk();
        $response->assertViewIs('bundles.index');
    }

    public function test_can_create_bundle_via_ajax(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData());

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('production_bundles', ['bundle_no' => 'BND-TEST-001']);
    }

    public function test_bundle_no_must_be_unique(): void
    {
        ProductionBundle::create($this->validData());

        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('bundle_no');
    }

    public function test_quantity_must_be_greater_than_zero(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData(['quantity' => 0]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors('quantity');
    }

    public function test_completed_cannot_exceed_quantity(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData([
                'quantity'      => 100,
                'completed_qty' => 150,
            ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors('completed_qty');
    }

    public function test_rejected_cannot_exceed_quantity(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData([
                'quantity'     => 100,
                'rejected_qty' => 150,
            ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors('rejected_qty');
    }

    public function test_completed_plus_rejected_cannot_exceed_quantity(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData([
                'quantity'      => 100,
                'completed_qty' => 80,
                'rejected_qty'  => 30,
            ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors('completed_qty');
    }

    public function test_production_date_cannot_be_future(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('bundles.store'), $this->validData([
                'production_date' => now()->addDays(5)->format('Y-m-d'),
            ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors('production_date');
    }

    public function test_can_update_bundle(): void
    {
        $bundle = ProductionBundle::create($this->validData());

        $response = $this->actingAs($this->user)
            ->putJson(route('bundles.update', $bundle), $this->validData([
                'color' => 'Black',
                'completed_qty' => 95,
            ]));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('production_bundles', [
            'id'    => $bundle->id,
            'color' => 'Black',
            'completed_qty' => 95,
        ]);
    }

    public function test_can_soft_delete_bundle(): void
    {
        $bundle = ProductionBundle::create($this->validData());

        $response = $this->actingAs($this->user)
            ->deleteJson(route('bundles.destroy', $bundle));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSoftDeleted('production_bundles', ['id' => $bundle->id]);
    }

    public function test_can_view_bundle_detail(): void
    {
        $bundle = ProductionBundle::create($this->validData());

        $response = $this->actingAs($this->user)
            ->get(route('bundles.show', $bundle));

        $response->assertOk()
            ->assertSee('BND-TEST-001');
    }

    /* ------------------------------------------------------------------ */
    /*  Model Accessor Tests                                                 */
    /* ------------------------------------------------------------------ */

    public function test_balance_qty_accessor(): void
    {
        $bundle = new ProductionBundle([
            'quantity' => 100, 'completed_qty' => 70, 'rejected_qty' => 10,
        ]);
        $this->assertEquals(20, $bundle->balance_qty);
    }

    public function test_efficiency_pct_accessor(): void
    {
        $bundle = new ProductionBundle(['quantity' => 200, 'completed_qty' => 150, 'rejected_qty' => 0]);
        $this->assertEquals(75.0, $bundle->efficiency_pct);
    }

    public function test_rejection_pct_accessor(): void
    {
        $bundle = new ProductionBundle(['quantity' => 200, 'completed_qty' => 0, 'rejected_qty' => 30]);
        $this->assertEquals(15.0, $bundle->rejection_pct);
    }

    public function test_zero_quantity_returns_zero_percent(): void
    {
        $bundle = new ProductionBundle(['quantity' => 0, 'completed_qty' => 0, 'rejected_qty' => 0]);
        $this->assertEquals(0.0, $bundle->efficiency_pct);
        $this->assertEquals(0.0, $bundle->rejection_pct);
    }

    /* ------------------------------------------------------------------ */
    /*  API Tests                                                            */
    /* ------------------------------------------------------------------ */

    public function test_api_login_returns_token(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $response = $this->postJson('/api/v1/login', [
            'email'    => $user->email,
            'password' => 'secret',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['success', 'token', 'user']);
    }

    public function test_api_list_bundles_requires_auth(): void
    {
        $response = $this->getJson('/api/v1/bundles');
        $response->assertUnauthorized();
    }

    public function test_api_create_bundle(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/bundles', $this->validData());

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.bundle_no', 'BND-TEST-001');
    }

    public function test_api_dashboard(): void
    {
        $token = $this->user->createToken('test')->plainTextToken;
        ProductionBundle::create($this->validData());

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/v1/dashboard');

        $response->assertOk()
            ->assertJsonStructure(['success', 'data' => [
                'total_bundles', 'total_quantity', 'total_completed',
                'total_rejected', 'avg_efficiency', 'today_production', 'today_rejection',
            ]]);
    }

    /* ------------------------------------------------------------------ */
    /*  Search / Filter Tests                                                */
    /* ------------------------------------------------------------------ */

    public function test_search_by_bundle_no(): void
    {
        ProductionBundle::create($this->validData(['bundle_no' => 'FINDME-001']));
        ProductionBundle::create($this->validData(['bundle_no' => 'OTHER-002']));

        $response = $this->actingAs($this->user)
            ->get(route('bundles.index', ['search' => 'FINDME']));

        $response->assertOk()
            ->assertSee('FINDME-001')
            ->assertDontSee('OTHER-002');
    }

    public function test_filter_by_buyer(): void
    {
        $buyer2 = Buyer::create(['buyer_name' => 'Other Buyer']);
        $style2 = Style::create(['buyer_id' => $buyer2->id, 'style_no' => 'OTH-001']);

        ProductionBundle::create($this->validData(['bundle_no' => 'A-001']));
        ProductionBundle::create($this->validData([
            'bundle_no' => 'B-001',
            'buyer_id'  => $buyer2->id,
            'style_id'  => $style2->id,
        ]));

        $response = $this->actingAs($this->user)
            ->get(route('bundles.index', ['buyer_id' => $this->buyer->id]));

        $response->assertOk()
            ->assertSee('A-001')
            ->assertDontSee('B-001');
    }
}
