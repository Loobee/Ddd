<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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