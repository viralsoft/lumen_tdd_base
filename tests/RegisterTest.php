<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    public function test_user_can_register()
    {

        $this->post('/auth/register', [
            'email' => 'xghostvn47122222@gmail.com',
            'password' => '1234qwer',
            'password_confirmation' => '1234qwer',
            'name' => 'tunglx'
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure(
            ['msg']
        );
    }

    public function test_user_cannot_register()
    {

        $this->post('/auth/register', [
            'email' => 'admin@gmail.com',
            'password' => '1234qwer',
            'password_confirmation' => '1234qwer',
            'name' => 'tunglx'
        ]);

        $this->seeStatusCode(422);

        $this->seeJsonStructure(
            ['email']
        );
    }

    public function test_user_register_with_no_data()
    {

        $this->post('/auth/register', []);

        $this->seeStatusCode(422);

        $this->seeJsonStructure(
            ['email']
        );
    }


}
