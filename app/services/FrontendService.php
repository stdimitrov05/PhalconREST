<?php

namespace App\Services;

/**
 * Business-logic for site frontend
 *
 * Class FrontendService
 */
class FrontendService extends AbstractService
{
    /**
     * Returns the status of the API
     * @return array
     */
    public function index(): array
    {
        return [
            'status' => 'Working!'
        ];
    }
}
