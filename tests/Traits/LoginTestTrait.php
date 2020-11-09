<?php


namespace Traits;


trait LoginTestTrait
{
    public function login()
    {
        $this->post('/auth/register', [
            'email' => 'demoTest@gmail.com',
            'password' => '1234qwer',
            'password_confirmation' => '1234qwer',
            'name' => 'tunglx'
        ]);

        $this->post('/auth/login', [
            'email' => 'demoTest@gmail.com',
            'password' => '1234qwer',
        ]);

        $response = json_decode($this->response->getContent(), true);

        return $response;
    }

    public function createProfile()
    {
        $data = $this->login();

        $this->post('auth/users/create', [
            'birthday' => '1995-07-25',
            'phone' => '0889472274'
        ],[
            'Authorization' => "bearer " . $data['access_token']
        ]);

        return $data;

    }
}
