<?php
/**
 * Copyright (c) 2011 Endeavor Systems, Inc.
 *
 * This file is part of OpenFISMA.
 *
 * OpenFISMA is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * OpenFISMA is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with OpenFISMA.  If not, see
 * {@link http://www.gnu.org/licenses/}.
 */

/**
 ** Dummy class to implements Fisma_Zend_Acl_OriganizationDependency
 ** @author     Duy K. Bui <duy.bui@endeavorsystems.com>
 ** @copyright  (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 ** @license    http://www.openfisma.org/content/license GPLv3
 ** @package    Test
 ** @subpackage Test_Library
 **/

class Test_Library_Fisma_Zend_MockOrg implements Fisma_Zend_Acl_OrganizationDependency
{
    public $orgId; //as string
    /*
     * lazy constructor
     * @param string orgId
     * @return void
     */
    public function __construct($orgId = '')
    {
        $this->orgId = $orgId;
    }
    /*
     * @return string
     */
    public function getOrganizationDependencyId()
    {
        return $this->orgId;
    }
}
