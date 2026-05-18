<?php

namespace Tests\Feature;

use App\Models\EmploymentContract;
use App\Models\RecruitmentHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RhReportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_diverse_displays_report_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('rh-reports.diverse'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Reports/Diverse')
        );
    }

    public function test_diverse_displays_filtered_contracts(): void
    {
        $user = User::factory()->create();
        EmploymentContract::factory(2)->create();

        $response = $this->actingAs($user)->get(route('rh-reports.diverse', ['search' => '']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Reports/Diverse')
            ->has('contracts')
        );
    }

    public function test_vacations_displays_report_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('rh-reports.vacations'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Reports/Vacations')
        );
    }

    public function test_vacations_displays_filtered_history(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        RecruitmentHistory::factory(2)->create(['employment_contract_id' => $contract->id]);

        $response = $this->actingAs($user)->get(route('rh-reports.vacations'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Reports/Vacations')
            ->has('history')
        );
    }
}
