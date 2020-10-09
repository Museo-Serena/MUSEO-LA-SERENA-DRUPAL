<?php

namespace Drupal\custom_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Debug the process pipeline.
 *
 * Prints the input value, assuming that you are running the migration from the
 * command line, and sends it to the next step in the pipeline unaltered.
 *
 * Available configuration keys:
 * - label: (optional) a string to print before the debug output. Include any
 *   trailing punctuation or space characters.
 * - multiple: (optional) set to TRUE to ask the next step in the process
 *   pipeline to process array values individually, like the multiple_values
 *   plugin from the Migrate Plus module.
 *
 * Examples:
 *
 * @code
 * process:
 *   field_tricky:
 *     -
 *       plugin: convert_array
 *       source: whatever
 *     -
 *       plugin: next
 * @endcode
 *
 * This will print the source before passing it to the next plugin.
 *
 * @code
 * process:
 *   field_tricky:
 *     -
 *       plugin: convert_array
 *       source: whatever
 *       label: 'Step 1: '
 *       multiple: true
 *     -
 *       plugin: next
 * @endcode
 *
 * This does the same thing, but ensures that the next plugin will be called
 * once for each item in the source, if the source is an array.
 * It will also print "Debug Step 1: " before printing the source.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "convert_array",
 *   handle_multiples = TRUE
 * )
 */
class ConvertToArray extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Retrieve all images
    $values = explode(';', $value);

    $module_path = drupal_get_path('module', 'custom_migrate');

    // Create an array to store datas
    $images = array(); 
	  
    // Create an array with all datas
    foreach ($values as $key => $value) {
      // Clean a string for use in URL
      $images[$key]['source_path'] = $module_path . '/' . 'images/'. $value;
      $images[$key]['destination_path'] = 'public://objeto/imagenes/'. $value;
	  }
	  print_r($images);

    // Return value.	
    return $images;

  }
}
