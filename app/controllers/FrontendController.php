<?php

namespace App\Controllers;

use App\Exceptions\HttpExceptions\Http500Exception;
use App\Exceptions\ServiceException;

/**
 * Frontend controller
 */
class FrontendController extends AbstractController
{
    /**
     * Index action
     * @return array
     */
    public function index(): array
    {
        try {
            $response = $this->frontendService->index();

        } catch (ServiceException $e) {
            throw new Http500Exception('Internal Server Error', $e->getCode(), $e);
        }

        return $response;
    }

}
