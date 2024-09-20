<?php

namespace Drupal\auto_alt;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['auto_alt.settings'];
  }

  public function getFormId() {
    return 'auto_alt_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('auto_alt.settings');

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ChatGPT API Key'),
      '#default_value' => $config->get('api_key'),
      '#required' => TRUE,
    ];

    $form['api_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Endpoint'),
      '#default_value' => $config->get('api_endpoint') ?: 'https://api.openai.com/v1/chat/completions',
      '#required' => TRUE,
    ];

    $form['model'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Model'),
      '#default_value' => $config->get('model') ?: 'gpt-4o',
      '#required' => TRUE,
    ];

    $form['generate_on_upload'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Generate alt text on upload'),
      '#default_value' => $config->get('generate_on_upload'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('auto_alt.settings')
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('api_endpoint', $form_state->getValue('api_endpoint'))
      ->set('model', $form_state->getValue('model'))
      ->set('generate_on_upload', $form_state->getValue('generate_on_upload'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}

