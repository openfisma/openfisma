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
 * UserTable
 *
 * @uses Fisma_Doctrine_Table
 * @package Model
 * @copyright (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com>
 * @license http://www.openfisma.org/content/license GPLv3
 */
class UserTable extends Fisma_Doctrine_Table implements Fisma_Search_Searchable, Fisma_Search_Facetable
{
    /**
     * Implement the interface for Searchable
     */
    public function getSearchableFields()
    {
        return array (
            'username' => array(
                'initiallyVisible' => true,
                'label' => 'User Name',
                'sortable' => true,
                'type' => 'text'
            ),
            'title' => array(
                'initiallyVisible' => false,
                'label' => 'Title',
                'sortable' => true,
                'type' => 'text'
            ),
            'nameFirst' => array(
                'initiallyVisible' => true,
                'label' => 'First Name',
                'sortable' => true,
                'type' => 'text'
            ),
            'nameLast' => array(
                'initiallyVisible' => true,
                'label' => 'Last Name',
                'sortable' => true,
                'type' => 'text'
            ),
            'email' => array(
                'initiallyVisible' => true,
                'label' => 'E-Mail Address',
                'sortable' => true,
                'type' => 'text'
            ),
            'phoneOffice' => array(
                'initiallyVisible' => true,
                'label' => 'Office Phone',
                'sortable' => true,
                'type' => 'text'
            ),
            'phoneMobile' => array(
                'initiallyVisible' => false,
                'label' => 'Mobile Phone',
                'sortable' => true,
                'type' => 'text'
            ),
            'createdTs' => array(
                'initiallyVisible' => false,
                'label' => 'Created Date',
                'sortable' => true,
                'type' => 'datetime'
            ),
            'modifiedTs' => array(
                'initiallyVisible' => false,
                'label' => 'Modified Date',
                'sortable' => true,
                'type' => 'datetime'
            ),
            'lastRob' => array(
                'initiallyVisible' => false,
                'label' => 'Last ROB Date',
                'sortable' => true,
                'type' => 'datetime'
            ),
            'lockType' => array(
                'enumValues' => $this->getEnumValues('lockType'),
                'initiallyVisible' => false,
                'label' => 'Account Lock',
                'sortable' => true,
                'type' => 'enum'
            ),
            'published' => array(
                'type' => 'boolean',
                'label' => 'Visible',
                'initiallyVisible' => true,
                'sortable' => true
            ),
            'lastLoginIp' => array(
                'initiallyVisible' => false,
                'label' => 'Last Login IP',
                'sortable' => true,
                'type' => 'text'
            )
        );
    }

    /**
     * Returns an array of faceted filters
     *
     * @return array
     */
    public function getFacetedFields()
    {
        return array(
            array(
                'label' => 'Account Status',
                'column' => 'lockType',
                'filters' => array(
                    array(
                        'label' => 'Active',
                        'operator' => 'enumNotIn',
                        'operands' => $this->getEnumValues('lockType')
                    ),
                    array(
                        'label' => 'Disabled',
                        'operator' => 'enumIs',
                        'operands' => array('manual')
                    ),
                    array(
                        'label' => 'Locked',
                        'operator' => 'enumIn',
                        'operands' => array('expired', 'inactive', 'password')
                    )
                )
            ),
            array(
                'label' => 'Lock Reason',
                'column' => 'lockType',
                'filters' => array(
                    array(
                        'label' => 'Inactivity',
                        'operator' => 'enumIs',
                        'operands' => array('inactive')
                    ),
                    array(
                        'label' => 'Password Expiration',
                        'operator' => 'enumIs',
                        'operands' => array('expired')
                    ),
                    array(
                        'label' => 'Invalid Login Attempts',
                        'operator' => 'enumIs',
                        'operands' => array('password')
                    )
                )
            ),
            array(
                'label' => 'Visible',
                'column' => 'published',
                'filters' => array(
                    array(
                        'label' => 'Visible',
                        'operator' => 'booleanYes',
                        'operands' => array()
                    ),
                    array(
                        'label' => 'Not Visible',
                        'operator' => 'booleanNo',
                        'operands' => array()
                    )
                )
            )
        );
    }

    /**
     * Implement required interface, but there is no field-level ACL in this model
     *
     * @return array
     */
    public function getAclFields()
    {
        return array();
    }

    /**
     * getUserByUserRoleIdQuery
     *
     * @param mixed $userRoleId
     * @access public
     * @return void
     */
    public function getUserByUserRoleIdQuery($userRoleId)
    {
        return Doctrine_Query::create()
               ->from('User u')
               ->innerJoin('u.UserRole ur')
               ->where('ur.userroleid = ?', $userRoleId);
    }

    /**
     * getUsersLikeUsernameQuery
     *
     * @param mixed $query
     * @access public
     * @return void
     */
    public function getUsersLikeUsernameQuery($query, $includeLockedUser = false)
    {
        $query = Doctrine_query::create()
               ->from('User u')
               ->where('u.username LIKE ?', $query . '%');

        // Do not display locked user with locktype of manual
        if (!$includeLockedUser) {
            $query->andWhere('(u.locktype is null or u.locktype != ?)', 'manual');
        }

        return $query;
    }

    /**
     * Build the query for getRoles()
     *
     * @param mixed $userId
     * @param mixed $hydrationMode Optional, defaults to Doctrine::HYDRATE_SCALAR.
     * @return Doctrine_Query
     */
    public function getRolesQuery($userId, $hydrationMode = Doctrine::HYDRATE_SCALAR)
    {
        $userRolesQuery = Doctrine_Query::create()
                          ->select('u.id, r.*')
                          ->from('User u')
                          ->innerJoin('u.Roles r')
                          ->where('u.id = ?', $userId)
                          ->setHydrationMode($hydrationMode);
        return $userRolesQuery;
    }
}
