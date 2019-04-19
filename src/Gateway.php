<?php


namespace Paynl\SDK;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

class Gateway
{
    private $token;
    private $tokenCode;
    private $baseUrl;

    public function __construct(array $config = [])
    {
        $this->setDefaults($config);
    }

    public function transaction(): Transaction{
        return new Transaction($this->getHttpClient());
    }

    private function setDefaults(array $config)
    {
        $defaults = [
            'token' => null,
            'tokenCode' => null,
            'baseUrl' => 'https://new-rest-api.local'
        ];

        $config = array_merge($defaults, $config);

        $this->token = $config['token'];
        $this->tokenCode = $config['tokenCode'];
        $this->baseUrl = $config['baseUrl'];
    }

    private function getAuthHeader()
    {
        if (!isset($this->token)) return null;
        $user = $this->tokenCode ?? 'token';
        $content = $user . ":" . $this->token;

        return "Basic " . base64_encode($content);
    }

    private function addHeaderMiddleware($header, $content)
    {
        return Middleware::mapRequest(function(RequestInterface $r) use ($header, $content){
            return $r->withHeader($header, $content);
        });
    }

    private function getHttpClient(): Client
    {
        $stack = new HandlerStack();
        $stack->setHandler(\GuzzleHttp\choose_handler());

        $stack->push($this->addHeaderMiddleware('Accept', 'application/json'));

        $authHeader = $this->getAuthHeader();
        if(!is_null($authHeader)){
            $stack->push($this->addHeaderMiddleware('Authorization', $authHeader));
        }
        
        $client = new Client(['base_uri' => $this->baseUrl, 'handler' => $stack]);

        return $client;
    }
}