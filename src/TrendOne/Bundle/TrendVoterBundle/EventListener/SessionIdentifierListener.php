<?php

namespace TrendOne\Bundle\TrendVoterBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * SessionIdentifierListener
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class SessionIdentifierListener implements EventSubscriberInterface
{
    /** @var SecureRandomInterface */
    private $secureRandom;

    public function __construct(SecureRandomInterface $secureRandom)
    {
        $this->secureRandom = $secureRandom;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if (!$session->has('identifier')) {
            $this->resetIdentifier($session);
        }
    }

    public function resetIdentifier(SessionInterface $session)
    {
        $session->set('identifier', base64_encode($this->secureRandom->nextBytes(32)));
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 64),
        );
    }
}
