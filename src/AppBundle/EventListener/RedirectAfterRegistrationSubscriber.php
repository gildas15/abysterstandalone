<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\component\routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
	 private $router;
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
	}
	public function onRegistrationSuccess(FormEvent $event)
    {
    	$url = $this->router->generate('home');
        $response = new RedirectResponse($url);
		$event->setResponse($response);
		$user = $event->getForm()->getData();
		$user->addRole('ROLE_SUPER_ADMIN');
	}

    public static function getSubscribedEvents()
    {
    	return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
		];
	}

}


