<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\VueController;
use Illuminate\View\View;
use Tests\TestCase;

class VueControllerTest extends TestCase
{
    /** @test */
    public function test_vue_controller_index(): void
    {
        $controller = new VueController();

        self::assertSame(View::class, get_class($controller->index()));
    }
}
