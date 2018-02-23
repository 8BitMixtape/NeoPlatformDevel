<?php
if($_SERVER["HTTP_HOST"]=="localhost:8000"){
    return [
        // URL to your Flarum forum
        'flarum_url' => 'http://localhost:8000/neo-platform-devel/community',
        // Domain of your main site (without http://)
        'root_domain' => 'localhost',
        // Create a random key in the api_keys table of your Flarum forum
        'flarum_api_key' => 'NotSecureToken',
        // Random token to create passwords
        'password_token' => 'NotSecureToken',
        // How many days should the login be valid
        'lifetime_in_days' => 14,
    ];    
    }else{
        return [
            // URL to your Flarum forum
            'flarum_url' => 'http://community.8bitmixtape.cc',
            // Domain of your main site (without http://)
            'root_domain' => 'neo.8bitmixtape.cc',
            // Create a random key in the api_keys table of your Flarum forum
            'flarum_api_key' => 'HGDHGShdgshdgshJGHbbsb56576GGggG',
            // Random token to create passwords
            'password_token' => 'KkkKKkNASJHKJhbsbjBS45VGHVbbbbgs',
            // How many days should the login be valid
            'lifetime_in_days' => 14,
        ];  
    }
?>