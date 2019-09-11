<?php
declare(strict_types=1);

namespace Lucek\FormHandlerBundle\Event\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class KernelRequestListener
 * @package Calendarium\Listener
 */
class KernelRequestJsonConverter
{
    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (false === strpos(
                $request->headers->get('Content-Type', ''),
                'application/json'
            )) {
            return;
        }
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
}
