<?php namespace Mixtapes\Mixtapes\Classes;

class Flarum
{
    const REMEMBER_ME_KEY = 'flarum_remember';
    const SESSION_KEY = 'flarum_session';

    private $config;
    private $token;

    public function __construct()
    {
        $this->config = require __DIR__ . '/config.php';
    }

    /**
     * Call this method after your user is successfully authenticated.
     *
     * @param $username
     * @param $email
     */
    public function login($username, $email)
    {
        $password = $this->createPassword($username);
        $this->token = $this->getToken($username, $password);

        if (empty($token)) {
            $this->signup($username, $password, $email);
            $this->token = $this->getToken($username, $password);
        }

        $this->setRememberMeCookie($this->token);
    }

    /**
     * Call this method after you logged out your user.
     */
    public function logout()
    {
        $this->removeRememberMeCookie();
    }

    /**
     * Redirects a user back to the forum.
     */
    public function redirectToForum()
    {
        header('Location: ' . $this->config['flarum_url']);
        die();
    }


    public function createDiscussion($username, $title, $content, $tags_id = 2)
    {
        $password = $this->createPassword($username);

        if(!$this->token) {
            $this->token = $this->getToken($username, $password);
        }
        
        //$payload = '{"data":{"type":"discussions","attributes":{"title":"' . $title . '","content":"' . $content . '"},"relationships":{"tags":{"data":[{"type":"tags","id":"' . $tags_id . '"}]}}}}';
                    
        $payload = [
            'data' => [
                'type' => 'discussions',
                'attributes' => [
                    'title' => $title,
                    'content' => $content
                ],
                'relationships' => [
                    'tags' => [
                        'data' => [
                            ['type' => 'tags',
                            'id' => "$tags_id"]
                        ]
                    ]
                ]
            ]
        ];


        // die(json_encode($payload));
        
        $res = $this->sendPostRequestToken(
            "/api/discussions", $payload
        );
        
        
        if ( isset($res['data']['id']) )
        {
            $discus_id = isset($res['data']['id']) ? $res['data']['id'] : 0;
            $post_id = $res['data']['relationships']['posts']['data'][0]['id']; 
            return ['discuss_id' => $discus_id , 'post_id' => $post_id];
        }else{
            return 0;
        }

        

    }




    public function renameDiscussion($username, $id, $new_title)
    {
        $password = $this->createPassword($username);

        if(!$this->token) {
            $this->token = $this->getToken($username, $password);
        }
        
        //{"data":{"type":"discussions","id":"56","attributes":{"title":"[mixtape] Mini Synth Neopixel Updated v0"}}}

        $payload = [
            'data' => [
                'type' => 'discussions',
                'id' => $id,
                'attributes' => [
                    'title' => $new_title
                ]
            ]
        ];


        // die(json_encode($payload));
        
        $res = $this->sendPatchRequestToken(
            "/api/discussions/" . $id, $payload
        );

        return isset($res['data']['id']) ? $res['data']['id'] : 0;

    }


    public function updateDiscussionMsg($username, $id, $new_msg)
    {
        $password = $this->createPassword($username);

        if(!$this->token) {
            $this->token = $this->getToken($username, $password);
        }
        
        //{"data":{"type":"posts","id":"66","attributes":{"content":"Synth name: NEO Rainbow Speed Control\nUrl: https://neo.8bitmixtape.cc/mixtape/detail/27\nDescription: \n\n\n\nNYANCAT Rainbow, based on ChrisMicro Testcomponent advanced (edit)"}}}

        $payload = [
            'data' => [
                'type' => 'post',
                'id' => $id,
                'attributes' => [
                    'content' => $new_msg
                ]
            ]
        ];


        // die(json_encode($payload));
        
        $res = $this->sendPatchRequestToken(
            "/api/posts/" . $id, $payload
        );

        // dd($res);

        return isset($res['data']['id']) ? $res['data']['id'] : 0;

    }

    private function createPassword($username)
    {
        return hash('sha256', $username . $this->config['password_token']);
    }

    private function getToken($username, $password)
    {
        $data = [
            'identification' => $username,
            'password' => $password,
            'lifetime' => $this->getLifetimeInSeconds(),
        ];

        $response = $this->sendPostRequest('/api/token', $data);

        return isset($response['token']) ? $response['token'] : '';
    }

    private function signup($username, $password, $email)
    {
        $data = [
            "data" => [
                "type" => "users",
                "attributes" => [
                    "username" => $username,
                    "password" => $password,
                    "email" => $email,
                ]
            ]
        ];

        $response = $this->sendPostRequest('/api/users', $data);

        return isset($response['data']['id']);
    }

    private function sendPatchRequestToken($path, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: Token ' . $this->token,
                'X-HTTP-Method-Override: PATCH'
            ]
        );
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    private function sendPostRequestToken($path, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: Token ' . $this->token
            ]
        );
        $result = curl_exec($ch);

        return json_decode($result, true);
    }


    private function sendPostRequest($path, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: Token ' . $this->config['flarum_api_key'] . '; userId=1',
            ]
        );
        $result = curl_exec($ch);
        
        return json_decode($result, true);
    }

    private function setRememberMeCookie($token)
    {
        $this->setCookie(self::REMEMBER_ME_KEY, $token, time() + $this->getLifetimeInSeconds());
    }

    private function removeRememberMeCookie()
    {        
        unset($_COOKIE[self::SESSION_KEY]);        
        unset($_COOKIE[self::REMEMBER_ME_KEY]);
        $this->setCookie(self::REMEMBER_ME_KEY, '', time() - 10);
        $this->setCookie(self::SESSION_KEY, '', time() - 10);

    }

    private function setCookie($key, $token, $time)
    {
        setcookie($key, $token, $time, '/', $this->config['root_domain']);
    }

    private function getLifetimeInSeconds()
    {
        return $this->config['lifetime_in_days'] * 60 * 60 * 24;
    }
}
?>