<?php
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Twig\Environment;

class ExceptionListener
{

    private const STATUS_ERROR = "error";
    private const STATUS_FAIL = "fail";
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(ExceptionEvent $event): void
    {

        // You get the exception object from the received event
        $exception = $event->getThrowable();
        switch ($exception->getCode()){
            case 400:
            case 401:
            case 403:
            case 404:
            case 405:
            case 406:
            case 407:
            case 408:
            case 409:
                $error = [
                    "status" => self::STATUS_ERROR,
                    "error" => $exception->getMessage(),
                ];
                $code = $exception->getCode();
                break;
            case 422:
                $error = [
                    "status" => self::STATUS_FAIL,
                    "error" => $exception->getMessages(),
                ];
                $code = $exception->getCode();
                break;
            default:
                $error = [
                    "status" => self::STATUS_ERROR,
                    "error" => $exception->getMessage(),
                    //"error" => "Unknown Error",
                ];
                $code = Response::HTTP_BAD_REQUEST;
                break;
        }
        // sends the modified response object to the event
        if($this->isApi($event->getRequest()->getPathInfo())){
            $response = new JsonResponse();
            $response->setData($error);
            $response->setStatusCode($code);
            $event->setResponse($response);
        }else{
            $response = new Response($this->twig->render('error.html.twig', [
                'code' => $code,
            ]));
            $event->setResponse($response);
        }
    }

    /**
     * @desc Check if the request is an API request
     * @param string $path
     * @return bool
     */
    private function isApi($path){

        return preg_match("/^\/api/", $path);

    }
}