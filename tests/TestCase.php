<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (class_exists(\App\Models\User::class)) {
            if (!isset($this->skipAutoAuth) || !$this->skipAutoAuth) {
                $admin = \App\Models\User::factory()->create([
                    'role' => 'admin',
                ]);
                $this->actingAs($admin);
            }
        }
    }
}
