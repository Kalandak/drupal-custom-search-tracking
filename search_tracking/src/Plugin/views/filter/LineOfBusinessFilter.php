<?php

namespace Drupal\search_tracking\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
 * Filters tracking data by the line of business.
 *
 * @ViewsFilter("line_of_business")
 */
class LineOfBusinessFilter extends FilterPluginBase {

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
      'Part A' => $this->t('Part A'),
      'Part B' => $this->t('Part B'),
    ];

    $form['value'] = [
      '#type' => 'select',
      '#title' => $this->t('Line of Business'),
      '#options' => $options,
      '#default_value' => 'Part A',
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
      $query->addWhereExpression(0, "search_tracking.business = :line_of_business[]", [':line_of_business[]' => $this->value]);
    }
  }

}
