<?php

namespace Drupal\url_shortener_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\{FieldItemBase, FieldStorageDefinitionInterface, FieldItemListInterface};
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
* Plugin implementation of the 
*    'URL Shortener Field Formatter' formatter.
*
* Shortens the URL Link field.
*
* @FieldFormatter(
*   id = "url_shortener_field_formatter",
*   label = @Translation("URL Shortener Field Formatter"),
*   field_types = {
*     "link",
*   }
* )
*/
class UrlShortenerFieldFormatter extends LinkFormatter  {
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = parent::viewElements($items, $langcode);
        $settings = $this->getSettings();
    
        $id = $items->getEntity()->id();
        foreach ($element as $index => &$item) {
            $url_shortener_service = \Drupal::service('url_shortener_module.url_shortener');
            $url_shortener_service->shorten_url($id, $item);
        }     
    
        return $element;
    }
}