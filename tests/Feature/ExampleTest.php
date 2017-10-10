<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = factory(\App\User::class)->create();
        $episode = factory(\App\Episode::class)->create();

        $response = $this->actingAs($user)->json('POST', route('listeners.store'), ['id' => $episode->id]);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->put(route('listeners.update', $episode->id), [
            'time' => 20,
        ]);
        $response->assertStatus(200);
        dd($user->episodes()->get());
        $this->assertEquals(1, $user->episodes()->count());
    }
}
