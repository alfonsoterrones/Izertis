<?php

namespace Drupal\izertis\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Izertis settings for this site.
 */
class MarvelForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'izertis_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['izertis.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $service = \Drupal::service('izertis.service');
    $form['tipo_marvel'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Tipo de contenido Marvel'),
      '#options' => $service->getTypes(),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('tipo_marvel') == NULL) {
      $form_state->setErrorByName('tipo_marvel', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $service = \Drupal::service('izertis.service');
    $arrayMarvel = $service->getContentMarvel($form_state->getValue('tipo_marvel'));
    $service->loadContentMarvel($arrayMarvel, $form_state->getValue('tipo_marvel'));
  }

}
