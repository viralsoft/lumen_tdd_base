<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Traits\LoginTestTrait;

class ProfileTest extends TestCase
{
    use DatabaseTransactions, LoginTestTrait;

    public function test_create_profile_success()
    {
        $response = $this->login();

        $token = $response['access_token'];

        $this->post('auth/users/create', [
            'birthday' => '1995-07-25',
            'phone' => '0889472274'
        ], [
            'Authorization' => "bearer " . $token
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure(
            [
                "data" => ['birthday', 'phone', 'user_id', 'updated_at', 'created_at']
            ]
        );
    }

    public function test_create_with_empty_data()
    {
        $response = $this->login();

        $token = $response['access_token'];

        $this->post('auth/users/create', [], [
            'Authorization' => "bearer " . $token
        ]);

        $this->seeStatusCode(422);

    }

    public function test_create_not_login()
    {
        $response = $this->post('auth/users/create', []);

        $response->seeStatusCode(401);
    }

    public function test_get_profile_success()
    {
        $responseLogin = $this->login();

        $token = $responseLogin['access_token'];

        $this->post('auth/users/create', [
            'birthday' => '1995-07-25',
            'phone' => '0889472274'
        ], [
            'Authorization' => "bearer " . $token
        ]);

        $this->get("auth/users/{$responseLogin['id']}", []);

        $this->seeStatusCode(200);
    }


    public function test_get_profile_with_not_login()
    {

        $this->post('auth/users/create', [
            'birthday' => '1995-07-25',
            'phone' => '0889472274'
        ]);

        $response = $this->get('auth/users/4', []);

        $response->seeStatusCode(401);
    }

    public function test_edit_profile_success()
    {
        $loginData = $this->createProfile();

        $token = $loginData['access_token'];

        $response = $this->patch("auth/users/{$loginData['id']}", [
            'birthday' => '1995-07-25',
            'phone' => '08894722123'
        ],
        [
            'Authorization' => "bearer " . $token
        ]);

        $response->seeStatusCode(200);
    }

    public function test_edit_profile_with_validation_fail()
    {
        $loginData = $this->createProfile();

        $token = $loginData['access_token'];

        $response = $this->patch("auth/users/{$loginData['id']}", [],
            [
                'Authorization' => "bearer " . $token
            ]);

        $response->seeStatusCode(422);
    }

    public function test_edit_others_profile()
    {
        $loginData = $this->createProfile();
        $otherData = $this->login();
        $token = $loginData['access_token'];

        $response = $this->patch("auth/users/{$otherData['id']}", [],
            [
                'Authorization' => "bearer " . $token
            ]);

        $response->seeStatusCode(422);
    }

    public function test_edit_profile_without_login()
    {
        $response = $this->patch("auth/users/1", []);

        $response->seeStatusCode(401);
    }

}
