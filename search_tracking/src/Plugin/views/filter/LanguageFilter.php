<?php

namespace Drupal\search_tracking\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
 * Filters tracking data by the line of business.
 *
 * @ViewsFilter("language_filter")
 */
class LanguageFilter extends FilterPluginBase {

  /**
   * {@inheritdoc}
   */
  public function adminSummary() {
    return $this->t('Filters tracking data by the line of business.');
  }

  /**
   * {@inheritdoc}
   */
  protected function valueForm(&$form, FormStateInterface $form_state) {
    $options = [
      'English' => $this->t('English'),
      'Spanish' => $this->t('Spanish'),
    ];

    $form['value'] = [
      '#type' => 'select',
      '#title' => $this->t('Language'),
      '#options' => $options,
      '#default_value' => 'English',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();

    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;

    if (!empty($this->value)) {
      $query->addWhereExpression(0, "search_tracking.language_facet = :language_filter[]", [':language_filter[]' => $this->value]);
    }
  }

}
