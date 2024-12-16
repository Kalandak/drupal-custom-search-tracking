<?php

namespace Drupal\search_tracking\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides coordinates and stores in session.
 */
class SearchTrackingController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function formData() {
    $jsonData = file_get_contents('php://input');
    $keyword = json_decode($jsonData, TRUE);
    if ($keyword['name']) {
      // phpcs:ignore
      $connection = \Drupal::service('database');
      $connection->insert('search_tracking')
        ->fields([
          'search' => $keyword['name'],
          'business' => $keyword['facet_business_name'],
          'language_facet' => $keyword['facet_language_name'],
          // phpcs:ignore
          'ip_address' => \Drupal::request()->getClientIp(),
          // phpcs:ignore
          'created_on' => \Drupal::time()->getRequestTime(),
          // Add more fields as needed.
        ])
        ->execute();
    }
    return new JsonResponse();
  }

  /**
   * {@inheritdoc}
   */
  public function searchTracking() {
    // phpcs:ignore
    $database = \Drupal::database();
    $query = $database->query("SELECT id,search,business,language_facet,ip_address,created_on FROM `search_tracking`");
    $result = $query->fetchAll();
    // phpcs:ignore
    \Drupal::service('page_cache_kill_switch')->trigger();
    return [
      '#theme' => 'search_tracking',
      '#items' => $result,
    ];
  }

}
