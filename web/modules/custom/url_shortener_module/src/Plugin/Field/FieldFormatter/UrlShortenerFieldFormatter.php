<?php

namespace Drupal\url_shortener_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\{FieldItemBase, FieldStorageDefinitionInterface};
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;


/**
* Plugin implementation of the 
*    'URL Shortener Field Formatter' formatter.
*
* @FieldFormatter(
*   id = "url_shortener_field_formatter",
*   label = @Translation("URL Shortener Field Formatter"),
*   field_types = {
*     "string_long",
*     "string",
*     "link",
*   }
* )
*/
class UrlShortenerFieldFormatter extends FormatterBase  {
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $elements = [];
    
        foreach ($items as $delta => $item) {
            $elements[$delta] = [
                '#markup' => "Hello formatter, the value is $item->value",
            ];
        }
    
        return $elements;
    }
}