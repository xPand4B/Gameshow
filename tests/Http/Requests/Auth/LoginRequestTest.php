<?php

namespace Tests\Http\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    /**
     * @return LoginRequest
     */
    private function getLoginRequest(): LoginRequest
    {
        return new LoginRequest();
    }

    /** @test */
    public function test_login_request_authorization(): void
    {
        self::assertTrue($this->getLoginRequest()->authorize());
    }

    /** @test */
    public function test_login_request_rules(): void
    {
        self::assertSame([
            'username' => 'required|string|max:20',
        ], $this->getLoginRequest()->rules());
    }
}
