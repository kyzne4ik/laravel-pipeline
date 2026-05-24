<?php

namespace Tests\Feature;

use App\Models\Enrollment;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_enroll_in_master_class(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $this->actingAs($visitor);

        $masterClass = MasterClass::factory()->create([
            'date' => '2026-10-10',
            'time_slot' => '09:00-11:00',
            'capacity' => 10,
        ]);

        $response = $this->post("/enroll/{$masterClass->id}");

        $response->assertRedirect(route('activity.show', $masterClass->activity_id));
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $visitor->id,
            'master_class_id' => $masterClass->id,
        ]);
    }

    public function test_visitor_cannot_enroll_twice(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $this->actingAs($visitor);

        $masterClass = MasterClass::factory()->create([
            'date' => '2026-10-10',
            'time_slot' => '09:00-11:00',
            'capacity' => 10,
        ]);

        Enrollment::factory()->for($visitor)->for($masterClass)->create();

        $response = $this->post("/enroll/{$masterClass->id}");

        $response->assertRedirect(route('activity.show', $masterClass->activity_id));
        $response->assertSessionHasErrors('error');
    }

    public function test_cannot_enroll_in_past_master_class(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $this->actingAs($visitor);

        $masterClass = MasterClass::factory()->create([
            'date' => '2020-01-01',
            'time_slot' => '09:00-11:00',
        ]);

        $response = $this->post("/enroll/{$masterClass->id}");

        $response->assertRedirect(route('activity.show', $masterClass->activity_id));
        $response->assertSessionHasErrors('error');
    }

    public function test_cannot_enroll_if_capacity_is_full(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $this->actingAs($visitor);

        $masterClass = MasterClass::factory()->create([
            'date' => '2026-10-10',
            'time_slot' => '09:00-11:00',
            'capacity' => 1,
        ]);

        Enrollment::factory()->for($masterClass)->create();

        $response = $this->post("/enroll/{$masterClass->id}");

        $response->assertRedirect(route('activity.show', $masterClass->activity_id));
        $response->assertSessionHasErrors('error');
    }

    public function test_instructor_cannot_enroll(): void
    {
        $instructor = User::factory()->instructor()->create();
        $this->actingAs($instructor);

        $masterClass = MasterClass::factory()->create([
            'date' => '2026-10-10',
            'time_slot' => '09:00-11:00',
        ]);

        $response = $this->post("/enroll/{$masterClass->id}");

        $response->assertForbidden();
    }
}
