<?php

namespace Drupal\izertis\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use \Drupal\taxonomy\Entity\Term;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Izertis event subscriber.
 */
class IzertisSubscriber implements EventSubscriberInterface {

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs event subscriber.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Kernel request event handler.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   Response event.
   */
  public function onKernelRequest(GetResponseEvent $event) {
    $this->messenger->addStatus(__FUNCTION__);
  }

  /**
   * Kernel response event handler.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   Response event.
   */
  public function onKernelResponse(FilterResponseEvent $event) {
    $this->messenger->addStatus(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
  }

  /**
   * Obtenemos los tipos de contenidos que queremos descargar
   * @return array devolvemos la taxonomía 'tipos'
   */
  public static function getTypes() {
    $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('tipos');
    $tipos = [];
    foreach ($terms as $item) {
      $tipos [$item->tid] = $item->name;
    }
    return  $tipos;
  }

  /**
   * Obtenemos los tipos de contenidos que queremos descargar
   * @return array devolvemos el contenido Marvel
   */
  public static function getContentMarvel($type) {

    $term = Term::load($type)->getName();
    $key = \Drupal::config('izertis.settings')->get('key');
    $hash = \Drupal::config('izertis.settings')->get('hash');
    $url = $_ENV['URL_MARVEL'];
    $constant = array("TIPO", "KEY", "HASH");
    $valores   = array($term, $key, $hash);
    $url = str_replace($constant, $valores, $url);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $data = curl_exec($curl);
    curl_close($curl);
    return Json::decode($data);
  }

  /**
   * Cargamos el tipo de contenido
   * @return array devolvemos la taxonomía 'tipos'
   */
  public static function loadContentMarvel($contentArray, $type) {
    foreach ($contentArray['data']['results'] as $item) {
      $query = \Drupal::entityQuery('node')
        ->condition('field_id_marvel', $item['id']);
      $nids = $query->execute();

      if ($nids == NULL) {
        $title = $item['title'] == NULL ? $item['name'] : $item['title'];
        Node::create([
          'field_tipo_marvel' => $type,
          'title' => $title,
          'status' => 1,
          'type' => 'marvel',
          'field_id_marvel' => $item['id'],
        ])->save();
      }
    }
  }

}
