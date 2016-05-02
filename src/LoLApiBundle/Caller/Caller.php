<?php

namespace LoLApiBundle\Caller;

use GuzzleHttp\Client;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Dowdow\LeagueOfLegendsAPIBundle\Caller\Caller as DowDowCaller;

class Caller extends DowDowCaller
{

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var Container
     */
    private $container;

    /**
     * Constructor
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->guzzle = new Client();
        $this->container = $container;
    }

    /**
     * Send a request and return a JSON object response
     * @param $request string
     * @param $region string
     * @param $param array
     * @throws InternalErrorException
     * @return mixed json response
     */
    public function send($request, $region, $param = null)
    {
        if ($param == null) {
            $param = array();
        }
        $urls = $this->container->getParameter('urls');
        $url = $urls['global'];
        if(array_key_exists($region, $urls))
        {
            $url = $urls[$region];
        }
        $request = str_replace('{region}', str_replace('global', '', $region), $request);
        $key = $this->container->getParameter('key');
        $param['api_key'] = $key;
        $response = $this->guzzle->get($url . $request, array('query' => $param));

        switch ($response->getStatusCode()) {
            case 400:
                throw new BadRequestHttpException();
                break;
            case 401:
                throw new UnauthorizedHttpException('');
                break;
            case 403:
                throw new AccessDeniedHttpException();
                break;
            case 429:
                throw new TooManyRequestsHttpException();
                break;
            case 500:
                throw new InternalErrorException();
                break;
            case 503:
                throw new ServiceUnavailableHttpException();
                break;
        }

        return json_decode($response->getBody());
    }

}