<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\VueController;
use Tests\TestCase;

class VueControllerTest extends TestCase
{
    /** @test */
    public function test_vue_controller_index(): void
    {
        $controller = new VueController();

        self::assertSame(\Illuminate\View\View::class, get_class($controller->index()));
    }
}
