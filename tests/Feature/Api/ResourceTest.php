<?php

namespace Tests\Feature\Api;

use App\Resource;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    public $user;


    public function testGetResource()
    {
        $response = $this->json('GET','/api/resources/abcd', ['api_token'=>'abcd'],['Accept'=>'application/json']);
        $data = json_decode($response->getContent(), true);
        print_r($data);
    }
}
