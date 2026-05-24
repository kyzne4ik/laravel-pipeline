<?php

namespace Tests\Feature;

use App\Models\CreativeActivity;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterClassFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_view_their_master_classes(): void
    {
        $instructor = User::factory()->instructor()->create();
        $this->actingAs($instructor);

        $masterClass = MasterClass::factory()->for($instructor, 'instructor')->create([
            'title' => 'Instructor Masterclass',
        ]);

        $response = $this->get('/cabinet');

        $response->assertSuccessful();
        $response->assertViewIs('cabinet.index');
        $response->assertSee('Instructor Masterclass');
    }

    public function test_visitor_cannot_view_cabinet(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $this->actingAs($visitor);

        $response = $this->get('/cabinet');

        $response->assertForbidden();
    }

    public function test_instructor_can_create_master_class(): void
    {
        $instructor = User::factory()->instructor()->create();
        $this->actingAs($instructor);
        $activity = CreativeActivity::factory()->create();

        $response = $this->post('/master-classes', [
            'activity_id' => $activity->id,
            'title' => 'New Awesome Masterclass',
            'description' => 'Description here',
            'date' => '2026-06-01',
            'time_slot' => '11:00-13:00',
            'capacity' => 15,
            'cost' => 500,
        ]);

        $response->assertRedirect('/cabinet');
        $this->assertDatabaseHas('master_classes', [
            'title' => 'New Awesome Masterclass',
            'instructor_id' => $instructor->id,
        ]);
    }

    public function test_cannot_create_master_class_with_overlapping_time(): void
    {
        $instructor = User::factory()->instructor()->create();
        $this->actingAs($instructor);
        $activity = CreativeActivity::factory()->create();

        MasterClass::factory()->create([
            'date' => '2026-06-01',
            'time_slot' => '11:00-13:00',
        ]);

        $response = $this->from('/master-classes/create')->post('/master-classes', [
            'activity_id' => $activity->id,
            'title' => 'Overlapping Masterclass',
            'description' => 'Description',
            'date' => '2026-06-01',
            'time_slot' => '11:00-13:00',
            'capacity' => 10,
            'cost' => 500,
        ]);

        $response->assertRedirect('/master-classes/create');
        $response->assertSessionHasErrors('time_slot');
        $this->assertDatabaseMissing('master_classes', [
            'title' => 'Overlapping Masterclass',
        ]);
    }

    public function test_instructor_can_edit_own_master_class(): void
    {
        $instructor = User::factory()->instructor()->create();
        $this->actingAs($instructor);

        $masterClass = MasterClass::factory()->for($instructor, 'instructor')->create([
            'description' => 'Old Description',
            'cost' => 500,
        ]);

        $response = $this->put("/master-classes/{$masterClass->id}", [
            'description' => 'New Description',
            'cost' => 800,
        ]);

        $response->assertRedirect('/cabinet');
        $this->assertDatabaseHas('master_classes', [
            'id' => $masterClass->id,
            'description' => 'New Description',
            'cost' => 800,
        ]);
    }

    public function test_instructor_cannot_edit_others_master_class(): void
    {
        $instructor1 = User::factory()->instructor()->create();
        $instructor2 = User::factory()->instructor()->create();

        $this->actingAs($instructor1);

        $masterClass = MasterClass::factory()->for($instructor2, 'instructor')->create();

        $response = $this->put("/master-classes/{$masterClass->id}", [
            'description' => 'New Description',
            'cost' => 800,
        ]);

        $response->assertForbidden();
    }
}
