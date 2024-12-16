<?php

/**
 * @file
 * Provides functionality for FCSO Search Tracking.
 */

/**
 * Implements hook_views_data().
 */
function search_tracking_views_data() {
  $data = [];
  $data['search_tracking']['table']['group'] = t('Search Tracking');
  $data['search_tracking']['table']['base'] = [
    'title' => t('Search Tracking'),
    'help' => t('Search Tracking data.'),
  ];
  // Fields.
  $data['search_tracking']['search'] = [
    'title' => t('Keyword'),
    'help' => t('Keywords searched in the site.'),
    'field' => [
      'id' => 'standard',
    ],
  ];
  $data['search_tracking']['business'] = [
    'title' => t('Line of Business'),
    'help' => t('Line of Business searched in the site.'),
    'field' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
      'title' => t('Line of Business'),
    ],

  ];
  $data['search_tracking']['language_facet'] = [
    'title' => t('Language'),
    'help' => t('Language searched in the site.'),
    'field' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
      'title' => t('Language'),
    ],
  ];
  $data['search_tracking']['ip_address'] = [
    'title' => t('Ip address'),
    'help' => t('Ip address of the device that the keyword searched from.'),
    'field' => [
      'id' => 'standard',
    ],
  ];
  $data['search_tracking']['created_on'] = [
    'title' => t('Searched on'),
    'help' => t('The keyword searched time.'),
    'field' => [
      'id' => 'date',
    ],
    'filter' => [
      'id' => 'date',
      'title' => t('Searched on'),
    ],
    'sort' => [
      'id' => 'date',
    ],
  ];
  return $data;
}
