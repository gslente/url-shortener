<?php

namespace Drupal\url_shortener_module\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;

/**
 * Class EntityTypeSubscriber.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class RedirectEventSubscriber implements EventSubscriberInterface {
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events[KernelEvents::REQUEST][] = ['redirect', 1000];
        return $events;
    }    

    /**
     * Redirects paths starting with multiple slashes to a single slash.
     *
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *   The RequestEvent to process.
     */
    public function redirect(RequestEvent $event) {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        if (strpos($path, '/redirect') === 0) {
            if (!empty($request->query->get('og'))) {
                $og = $request->query->get('og');
                $url_shortener_service = \Drupal::service('url_shortener_module.url_shortener');
                $og_link = $url_shortener_service->lengthen_url($og);
                $og_link = \Drupal::entityTypeManager()->getStorage('node')->load($og_link);
                $og_link = $og_link->field_article_link[0]->uri;
                $event->setResponse(new TrustedRedirectResponse($og_link));
            }
        }
    }    
}