<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    protected $request;

    /**
     * Helpers yang dimuat otomatis di semua controller.
     */
    protected $helpers = ['url', 'form'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Jangan diubah.
        parent::initController($request, $response, $logger);

        // $this->session = service('session');
    }
}
