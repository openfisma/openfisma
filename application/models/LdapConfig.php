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
 * LdapConfig
 * 
 * @author     Ryan Yang <ryan@users.sourceforge.net>
 * @copyright  (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Model
 */
class LdapConfig extends BaseLdapConfig
{
    /**
     *  Retrieve the ldap configuration(s)
     *
     *  @return array All the configurations of LDAP servers
     */
    public static function getConfig($ldapConfigs = null)
    {
        $ldapConfigs = (isset($ldapConfigs)) ? $ldapConfigs : Doctrine::getTable('LdapConfig')->findAll()->toArray();
        
        //Remove the id field from each LDAP configuration item
        foreach ($ldapConfigs as &$ldapConfig) {
            unset($ldapConfig['id']);
        }

        return $ldapConfigs;
    }
}
