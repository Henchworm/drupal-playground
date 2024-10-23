<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 */

// Define the Drupal root directory.
define('DRUPAL_ROOT', getcwd());

// Include the necessary bootstrap file.
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// Bootstrap Drupal.
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Serve the requested page.
menu_execute_active_handler();
