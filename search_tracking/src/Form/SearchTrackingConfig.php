<?php

namespace Drupal\search_tracking\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\core\Form\FormStateInterface;

/**
 * Search Form History editable configuration.
 */
class SearchTrackingConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'search_tracking.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'search_tracking_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('search_tracking.settings');

    $form['attr_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Attribute'),
      '#description' => $this->t('Select the attribute type.'),
      '#options' => [
        '1' => $this->t('ID'),
        '2' => $this->t('Class'),
        '3' => $this->t('URL Parameter'),
      ],
      '#default_value' => $config->get('attr_type'),
    ];
    $form['form_attr_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Form id'),
      '#description' => $this->t('Enter the form id of your form here. For example: #form-id'),
      '#states' => [
        'visible' => ['select[name="attr_type"]' => ['value' => '1']],
      ],
      '#default_value' => $config->get('form_attr_id'),
    ];
    $form['form_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Form class'),
      '#description' => $this->t('Enter the form class here. For example: .form-class'),
      '#states' => [
        'visible' => ['select[name="attr_type"]' => ['value' => '2']],
      ],
      '#default_value' => $config->get('form_class'),
    ];
    $form['url_param'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url parameter'),
      '#description' => $this->t('Enter the url parameter here.'),
      '#states' => [
        'visible' => ['select[name="attr_type"]' => ['value' => '3']],
      ],
      '#default_value' => $config->get('url_param'),
    ];
    $form['input_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Input name attribute'),
      '#description' => $this->t('Enter the input name attribute value here.'),
      '#states' => [
        'visible' => [
          ':input[name="attr_type"]' => [
            ['value' => '1'],
            ['value' => '2'],
          ],
        ],
      ],
      '#default_value' => $config->get('input_name'),
    ];

    $form['facet_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Line of Business facet name attribute'),
      '#description' => $this->t('Enter the Line of Business facet name attribute value here.'),
      '#states' => [
        'visible' => [
          ':input[name="attr_type"]' => [
            ['value' => '1'],
            ['value' => '2'],
          ],
        ],
      ],
      '#default_value' => $config->get('facet_name'),
    ];

    $form['facet_name_language'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Language facet name attribute'),
      '#description' => $this->t('Enter the Language facet name attribute value here.'),
      '#states' => [
        'visible' => [
          ':input[name="attr_type"]' => [
            ['value' => '1'],
            ['value' => '2'],
          ],
        ],
      ],
      '#default_value' => $config->get('facet_name_language'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('search_tracking.settings')
      ->set('attr_type', $form_state->getValue('attr_type'))
      ->set('form_attr_id', $form_state->getValue('form_attr_id'))
      ->set('form_class', $form_state->getValue('form_class'))
      ->set('url_param', $form_state->getValue('url_param'))
      ->set('input_name', $form_state->getValue('input_name'))
      ->set('facet_name', $form_state->getValue('facet_name'))
      ->set('facet_name_language', $form_state->getValue('facet_name_language'))
      ->save();
  }

}
