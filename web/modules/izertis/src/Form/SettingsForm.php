<?php

namespace Drupal\izertis\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Izertis settings for this site.
 */
class SettingsForm extends ConfigFormBase {

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

    $form['key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Key'),
      '#default_value' => $this->config('izertis.settings')->get('key'),
    ];
    $form['hash'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hash'),
      '#default_value' => $this->config('izertis.settings')->get('hash'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('key') == NULL) {
      $form_state->setErrorByName('key', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('izertis.settings')
      ->set('key', $form_state->getValue('key'))
      ->set('hash', $form_state->getValue('hash'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
