<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
require_once(dirname(__FILE__) . '/lmbTestTreeNode.class.php');
require_once(dirname(__FILE__) . '/lmbDetachedFixture.class.php');

/**
 * class lmbTestTreeShallowDirNode.
 *
 * @package tests_runner
 * @version $Id: lmbTestTreeShallowDirNode.class.php 6020 2007-06-27 15:12:32Z pachanga $
 */
class lmbTestTreeShallowDirNode extends lmbTestTreeNode
{
  protected $dir;
  protected $skipped;

  function __construct($dir)
  {
    if(!is_dir($dir))
      throw new Exception("'$dir' is not a directory!");

    $this->dir = $dir;
  }

  static function hasArtifacts($dir)
  {
    $artifacts = array('.init.php',
                       '.setup.php',
                       '.teardown.php',
                       '.ignore.php',
                       '.skipif.php');
    foreach($artifacts as $artifact)
    {
      if(file_exists($dir . '/' . $artifact))
        return true;
    }
    return false;
  }

  function getDir()
  {
    return $this->dir;
  }

  function init()
  {
    //deprecated
    if(file_exists($this->dir . '/.init.php'))
      include_once($this->dir . '/.init.php');
  }

  protected function _doCreateTestCase()
  {
    require_once(dirname(__FILE__) . '/lmbTestGroup.class.php');

    $label = $this->_getDirectoryLabel();
    $test = new lmbTestGroup($label);
    $fixture = new lmbDetachedFixture($this->dir . '/.setup.php',
                                      $this->dir . '/.teardown.php');
    $test->useFixture($fixture);
    return $test;
  }

  protected function _getDirectoryLabel()
  {
    if(file_exists($this->dir . '/.description'))
      return file_get_contents($this->dir . '/.description');
    else
      return 'Group test in "' . $this->dir . '"';
  }

  function isSkipped()
  {
    if(!is_null($this->skipped))
      return $this->skipped;

    if(file_exists($this->dir . '/.skipif.php'))
      $this->skipped = (bool)include($this->dir . '/.skipif.php');
    elseif(file_exists($this->dir . '/.ignore.php'))//deprecated
      $this->skipped = (bool)include($this->dir . '/.ignore.php');
    else
      $this->skipped = false;

    return $this->skipped;
  }
}

?>
