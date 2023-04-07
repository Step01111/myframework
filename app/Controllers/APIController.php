<?php
namespace App\Controllers;

use App\Exceptions\ErArgumentException;
use App\Exceptions\UnauthorizedException;

class APIController extends AbstractController
{
    protected $response;

    public function __construct()
    {
        parent::__construct();

        $this->response = new \stdClass();
        $this->response->ok = true;
    }

    protected function isAdmin()
    {
        if (!$this->user) {
            throw new UnauthorizedException('Нужно авторизоваться на сайте');
        }
        if (!$this->user->getAdmin()) {
            throw new UnauthorizedException('Не достаточно прав для этого действия');
        }
    }

    protected function useRequest($request)
    {
        if (!$request) {
            throw new ErArgumentException('В запросе отсутствуют данные');
        }

        return json_decode($request);
    }

    protected function errorResponse($error)
    {
        $this->response->ok = false;
        $this->response->error = $error->GetMessage();
        echo json_encode($this->response);
    }
}
