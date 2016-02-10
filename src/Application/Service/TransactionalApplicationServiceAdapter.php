<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Application\Service;

use Exception;
use Loobee\Ddd\Domain\Event\EventManager;

class TransactionalApplicationServiceAdapter implements ApplicationServiceInterface
{
    /**
     * @var ApplicationServiceInterface
     */
    private $service;

    /**
     * @var TransactionalSessionInterface
     */
    private $session;

    /**
     * @param EventManager $event_manager
     * @param ApplicationServiceInterface $service
     * @param TransactionalSessionInterface $session
     */
    public function __construct(
        ApplicationServiceInterface $service,
        TransactionalSessionInterface $session,
        EventManager $event_manager)
    {
        $this->service       = $service;
        $this->session       = $session;
        $this->event_manager = $event_manager;
    }


    public function execute($request = null)
    {
        try
        {
            return $this->session->executeAtomically(function() use($request)
            {
                return $this->service->execute($request);
            });
        }
        catch(Exception $e)
        {
            $this->event_manager->cleanEventContainers();

            throw $e;
        }
    }
}