<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    
    //protected $db;


    /**
     * Constructor.
     */

    /**
     * @var \App\Models\Prieds
     */
    protected $priedsModel;

    /**
     * @var GuzzleHttp|Client 
     */
    protected $client;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->priedsModel = model("App\Models\Prieds");
        $this->client = new Client();

        
        //$this->db = \Config\Database::connect();
    }

    public function runTokenCheck()
    {
        $token = $this->getLatestToken();

        return $this->checkToken($token);
    }

    protected function checkToken($token)
    {
        $client = new Client();
        $tokenModel = model('App\Models\Prieds');

        $response = $client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/auth-simple-token-check', [
            'headers' => [
                'x-prieds-token' => $token,
                'x-prieds-username' => 'AIO_INTEGRATION'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents());

        if ($data->valid == FALSE) {
            $newToken = $this->getNewToken();

            return $tokenModel->insert(["token" => $newToken]);
        }
    }

    private function getNewToken()
    {
        $client = new Client();
        $request = $client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/simple-token', [
            'headers' => [
                'x-prieds-secret-key' => 'E9A41B175EBC2086FAB7692C32F63EB1',
                'x-prieds-username' => 'AIO_INTEGRATION'
            ]
        ]);

        $response = json_decode($request->getBody()->getContents());

        if ($response->valid == TRUE) {
            return $response->token;
        }
    }

    protected function getLatestToken()
    {
        $tokenModel = model('App\Models\Prieds');

        $token = $tokenModel->select(["token"])->orderBy('id', 'desc')->first();

        return $token->token;
    }
}
