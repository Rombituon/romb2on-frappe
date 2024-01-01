<?php

namespace Romb2on\Frappe;

use Illuminate\Support\Facades\Http;

class Frappe
{
    public $apiKey;
    public $secretKey;
    public $headers;

    public $url;

    private $_docData;
    public $token;

    public function doctype($frappe=null)
    {
        return (new Doctype($frappe ?? $this));
    }

    public function __construct()
    {
        $this->apiKey = config('romb2on-frappe.frappe_api_key');
        $this->secretKey = config('romb2on-frappe.frappe_api_secret');
        $this->url=config('romb2on-frappe.frappe_url');

        $this->token = $this->apiKey.":".$this->secretKey;

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "token ".$this->token
        ];
    }

    public function authenticate($username=null,$password=null)
    {
        $response = Http::withHeaders($this->headers)
                    ->get($this->url."/api/method/login",[
                        'usr'=>$username ?? config('romb2on-frappe.frappe_username'),
                        'pwd'=>$password ?? config('romb2on-frappe.frappe_password'),
                    ]);

        return json_decode($response);
    }

    public function getUser($username)
    {       
        $response = Http::withHeaders($this->headers)
                    ->get($this->url."/api/resource/User/".$username);
        return json_decode($response);
    }

    public function logout()
    {
        $response = Http::withHeaders($this->headers)
                    ->get($this->url."/api/method/logout");

        return json_decode($response);
    }

    public function getApi($method_path,$data)
    {
        $jsonData = json_encode($data);
        //dd($jsonData);
        $response = json_decode(Http::withHeaders($this->headers)
                    ->post($this->url."/api/method/".$method_path,$data));

        if(isset($response->message))
        {
            return $response->message;
        }

        $json_str= '{
            "data":[]
        }';
        return json_decode($json_str);
        
    }

    
}
