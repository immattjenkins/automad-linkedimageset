<?php
/*
 *	Linked Image Sets
 *	Extension for Automad
 *
 *	Matt Jenkins
 *	http://mattjenkins.me
 *
 *	Licensed under the MIT license.
 */

namespace Extensions;

/*
 *  Builds a large group of images for use in
 *  a portfolio, project, or area where a large
 *  number of images need to be linking out of
 *  the current page
 */

class LinkedImageSet {

  /**
   *  Main method for the Linked Image Set
   *
   *  @param array $options
   *  @param object $Automad
   *  @return generated HTML for group of images
   */
  public function LinkedImageSet($options, $Automad) {

    $defaults = 	array(
          'files' => '*.jpg',
          'class' => false,
          'firstClass' => false,
          'target' => false,
          'caption' => false
        );

    // Merge defaults with options
    $options = array_merge($defaults, $options);

    // Get file list.
    $files = \Automad\Core\Parse::fileDeclaration($options['files'], $Automad->getCurrentPage());

    // Generate HTML to be returned
    $html = '<div class="linked_image_set">';
    $html .= self::generateLinkedImageSet($files,
                                          $options['class'],
                                          $options['firstClass'],
                                          $options['target'],
                                          $options['caption']);
    $html .= '</div>';

    return $html;
  }

  /**
   * Takes an array of files and generates the HTML <a> and <img> tags needed
   * to make them clickable linked images
   *
   * Based off of \Automad\Core\Html::generateImageSet
   *
   * @param array $files
   * @param string $class
   * @param string $class
   * @param string $class
   * @return generated HTML for linked images
   */
  public static function generateLinkedImageSet($files, $class = false, $firstClass = false, $target = false, $caption = false) {

    if(is_array($files)) {

      $html = '';
      $first = true;

      // We want to loop through each of the files
      foreach($files as $file) {

        // Creates a var that can be used to set the link to the page in ~/gui
        $linkVar = '<a href="' . \Automad\Core\Html::addVariable('link_' . \Automad\Core\Parse::sanitize(basename($file))) . '">';
        $linkVarEnd = '</a>';

        // Add class if defined
        if($class) {
          $classAttr = ' class="' . $class . '"';
        } else {
          $classAttr = '';
        }

        // If first class is set, we'll overwrite the usual class attribute
        if($first && $firstClass) {
          $classAttr = ' class="' . $firstClass . '"';
          $first = false;
        }

        // Generate html
        $html .= '<div' . $classAttr . '>' . $linkVar;

        $html .= \Automad\Core\Html::addImage($file,
                                              false,
                                              false,
                                              false,
                                              false,
                                              false,
                                              AM_HTML_CLASS_LIST_ITEM_IMG,
                                              $caption);
        $html .= '</div>' . $linkVarEnd;

      }

      return $html;

    }
  }

}

?>
