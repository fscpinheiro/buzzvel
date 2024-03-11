<?php

namespace Tests\Feature\Unit\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\HolidayPlanController;
use App\Http\Requests\HolidayPlanRequest;
use App\Models\HolidayPlan;


class HolidayPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_holiday_plan()
    {
        $holidayPlanData = [
            'title' => 'Férias no Brasil',
            'description' => 'Planejando passar uma semana no Brasil com a família.',
            'date' => '2024-07-01',
            'location' => 'Praia de Copacabana, Rio de Janeiro, Brasil',
            'participants' => 'Família'
        ];
        $response = $this->post('/api/v1/holiday-plans', $holidayPlanData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('holiday_plans', $holidayPlanData);
    }

    public function test_it_cannot_create_a_holiday_plan_without_a_title()
    {
        $holidayPlanData = [
            'description' => 'Planejando passar uma semana no Brasil com a família.',
            'date' => '2024-07-01',
            'location' => 'Praia de Copacabana, Rio de Janeiro, Brasil',
            'participants' => 'Família'
        ];

        $response = $this->post('/api/v1/holiday-plans', $holidayPlanData);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('holiday_plans', $holidayPlanData);
    }

    public function test_it_can_show_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $controller = new HolidayPlanController();
        $response = $controller->show($holidayPlan->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('holiday_plans', ['id' => $holidayPlan->id]);
    }

    public function test_it_can_update_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $holidayPlanData = [
            'title' => 'Férias no Brasil',
            'description' => 'Planejando passar uma semana no Brasil com a família.',
            'date' => '2024-07-01',
            'location' => 'Praia de Copacabana, Rio de Janeiro, Brasil',
            'participants' => 'Família'
        ];

        $response = $this->put('/api/v1/holiday-plans/' . $holidayPlan->id, $holidayPlanData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('holiday_plans', $holidayPlanData);
    }

    public function test_it_can_list_all_holiday_plans()
    {
        $holidayPlans = HolidayPlan::factory()->count(5)->create();

        $response = $this->get('/api/v1/holiday-plans');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_it_can_destroy_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $controller = new HolidayPlanController();
        $response = $controller->destroy($holidayPlan->id);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertDatabaseMissing('holiday_plans', ['id' => $holidayPlan->id]);
    }

    public function test_it_can_generate_a_pdf_for_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $controller = new HolidayPlanController();
        $response = $controller->generatePDF($holidayPlan->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }
}
