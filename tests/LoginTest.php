<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_success()
    {
        $this->post('/auth/register' ,[
            'email' => 'xghostvn47122222@gmail.com',
            'password' => '1234qwer',
            'password_confirmation' => '1234qwer',
            'name' => 'tunglx'
        ]);

        $this->post('/auth/login' ,[
            'email' => 'xghostvn47122222@gmail.com',
            'password' => '1234qwer',
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure(
            ['access_token', 'token_type', 'expires_in']
        );
    }

    public function test_login_fail_with_full_data()
    {
        $this->post('/auth/login' ,[
            'email' => 'xghostvn47122222@gmail.com',
            'password' => '1234qwerasdas',
        ]);

        $this->seeStatusCode(401);

        $this->seeJsonStructure(
            ['error']
        );
    }

    public function test_login_fail_with_empty_data()
    {
        $this->post('/auth/login' ,[]);

        $this->seeStatusCode(401);

        $this->seeJsonStructure(
            ['error']
        );
    }
}
