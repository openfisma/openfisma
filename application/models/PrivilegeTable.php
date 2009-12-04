<?php
/**
 * Copyright (c) 2008 Endeavor Systems, Inc.
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
 * PrivilegeTable
 * 
 * @author     Josh Boyd <joshua.boyd@endeavorsystems.com>
 * @copyright  (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Model
 * @version    $Id$
 */
class PrivilegeTable extends Doctrine_Table
{
    /**
     * Find the specified resoure, action and organization condition matched provileges
     * 
     * @param string $resource The specific resource to filter
     * @param string $action The specified action to filter
     * @param boolean $orgSpecific The specific organization to filter
     * @return array The matched privileges in array
     */
    public function findByResourceAndActionAndOrgSpecific($resource, $action, $orgSpecific) 
    {
        return Doctrine_Query::create()
               ->from('Privilege p')
               ->where('p.resource = ?', $resource)
               ->andWhere('p.action = ?', $action)
               ->andWhere('p.orgSpecific = ?', $orgSpecific)
               ->execute(array(), Doctrine::HYDRATE_ARRAY);
    }
}