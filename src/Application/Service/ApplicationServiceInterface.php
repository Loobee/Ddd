<?php

namespace Loobee\Ddd\Application\Service;

interface ApplicationServiceInterface
{
    /**
     * @param mixed $request
     *
     * @return mixed
     */
    public function execute($request);
}