<?php

namespace Tests\Feature;

use App\Models\CreativeActivity;
use App\Models\Enrollment;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_home_page(): void
    {
        $activities = CreativeActivity::factory()->count(3)->state(new Sequence(
            ['title' => 'First Title'],
            ['title' => 'Second Title'],
            ['title' => 'Third Title'],
        ))->create();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertViewIs('home');
        
        foreach ($activities as $activity) {
            $response->assertSee($activity->title);
        }
    }

    public function test_visitor_sees_enrolled_classes_on_home_page(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $activity = CreativeActivity::factory()->create();
        $masterClass = MasterClass::factory()->for($activity, 'activity')->create([
            'title' => 'My Test Masterclass'
        ]);

        Enrollment::factory()->for($user)->for($masterClass)->create();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertSee('My Test Masterclass');
    }
}
