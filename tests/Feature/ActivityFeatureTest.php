<?php

namespace Tests\Feature;

use App\Models\CreativeActivity;
use App\Models\MasterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_activity_details(): void
    {
        $activity = CreativeActivity::factory()->create([
            'title' => 'Test Activity',
        ]);

        $masterClass1 = MasterClass::factory()->for($activity, 'activity')->create([
            'description' => 'First Masterclass Description',
            'date' => '2026-05-10',
            'time_slot' => '09:00-11:00',
        ]);

        $masterClass2 = MasterClass::factory()->for($activity, 'activity')->create([
            'description' => 'Second Masterclass Description',
            'date' => '2026-05-10',
            'time_slot' => '11:00-13:00',
        ]);

        $response = $this->get(route('activity.show', $activity->id));

        $response->assertSuccessful();
        $response->assertViewIs('classes.show');
        $response->assertSee('Test Activity');
        $response->assertSee('First Masterclass Description');
        $response->assertSee('Second Masterclass Description');
    }
}
