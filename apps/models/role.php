<?php
/**
 * role.php
 *
 * role model
 *
 * @package Model
 * @author     Ryan ryan at users.sourceforge.net
 * @copyright  (c) Endeavor Systems, Inc. 2008 (http://www.endeavorsystems.com)
 * @license    http://www.openfisma.org/mw/index.php?title=License
 * @version $Id$
*/
require_once 'Abstract.php';

/**
 * @package Model
 * @author     Ryan ryan at users.sourceforge.net
 * @copyright  (c) Endeavor Systems, Inc. 2008 (http://www.endeavorsystems.com)
 * @license    http://www.openfisma.org/mw/index.php?title=License
 */

class Role extends Fisma_Model
{
    protected $_name = 'roles';
    protected $_primary = 'id';
}

