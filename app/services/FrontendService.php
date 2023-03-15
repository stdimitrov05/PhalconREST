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
     * @return array
     */
    public function index(): array
    {
        return [
            'status' => 'Working!'
        ];
    }
}
