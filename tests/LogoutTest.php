<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use Traits\LoginTestTrait;
class LogoutTest extends TestCase
{
    use DatabaseTransactions, LoginTestTrait;

    public function test_logout_success()
    {
        $this->login();

        $response = $this->delete('auth/logout');

        $response->seeStatusCode(200);
    }

    public function test_logout_not_login()
    {
        $response = $this->delete('auth/logout');

        $response->seeStatusCode(401);
    }
}
