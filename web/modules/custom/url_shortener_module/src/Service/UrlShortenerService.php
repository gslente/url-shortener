<?php

namespace Drupal\url_shortener_module\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UrlShortenerService {
    private const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $entity_type_manager;
    private $request;

    public function __construct(EntityTypeManagerInterface $entity_type_manager, RequestStack $request_stack) {
        $this->entity_type_manager = $entity_type_manager;
        $this->request = $request_stack->getCurrentRequest();
    }

    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('request_stack'),
        );
    }

    public function shorten_url($id, &$item){
        $shortened_url = $this->encode($id);
        $item['#title'] = $this->request->getSchemeAndHttpHost() . '/' . $shortened_url;
    }

    private function encode($id){
        $base = strlen(self::CHARS);
        $chars = [];

        while($id > 0){
            $val = $id % $base;
            $chars[] = self::CHARS[$val];
            $id = floor( $id / $base );
        }

        return implode( array_reverse($chars) );
    }
    
    public function test(&$item){
        $item['test'] = 'test';
    }
}