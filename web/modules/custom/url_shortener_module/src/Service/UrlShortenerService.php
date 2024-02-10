<?php

namespace Drupal\url_shortener_module\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use \Drupal\Core\Url;
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
        $url_object = Url::fromRoute('entity.node.canonical', ['node' => 101002], ['query' => ['og' => $shortened_url]]);

        $item['#title'] = $this->request->getSchemeAndHttpHost() . '/redirect?og=' . $shortened_url;
        $item['#url'] = $url_object;
    }

    public function lengthen_url($id){
        return $this->decode($id);
    }

    private function encode($num, $b=62){
        $base = self::CHARS;
        $r = $num  % $b ;
        $res = $base[$r];
        $q = floor($num / $b);

        while ($q) {
          $r = $q % $b;
          $q = floor($q/$b);
          $res = $base[$r].$res;
        }

        return $res;
    }

    private function decode($string){
        $base = strlen(self::CHARS);
        $limit = strlen($string);
        $res = strpos($base, $string[0]);

        for($i = 0; $i < $limit; $i++){
            $res = $base * $res + strpos(self::CHARS, $string[$i]);
        }

        return $res;
    }
}