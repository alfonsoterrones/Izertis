<?php

namespace Drupal\izertis\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Izertis routes.
 */
class IzertisController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
