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
 * SecurityControlTable
 *
 * @uses Fisma_Doctrine_Table
 * @package Model
 * @copyright (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com>
 * @license http://www.openfisma.org/content/license GPLv3
 */
class SecurityControlTable extends Fisma_Doctrine_Table implements Fisma_Search_Searchable
{
    /**
     * Implement the interface for Searchable
     */
    public function getSearchableFields()
    {
        return array (
            'code' => array(
                'initiallyVisible' => true,
                'label' => 'Code',
                'sortable' => true,
                'type' => 'text'
            ),
            'name' => array(
                'initiallyVisible' => true,
                'label' => 'Name',
                'sortable' => false,
                'type' => 'text'
            ),
            'class' => array(
                'enumValues' => $this->getEnumValues('class'),
                'initiallyVisible' => true,
                'label' => 'Class',
                'sortable' => true,
                'type' => 'enum'
            ),
            'family' => array(
                'initiallyVisible' => true,
                'label' => 'Family',
                'sortable' => true,
                'type' => 'text'
            ),
            'control' => array(
                'initiallyVisible' => true,
                'label' => 'Control',
                'sortable' => false,
                'type' => 'text'
            ),
            'supplementalGuidance' => array(
                'initiallyVisible' => false,
                'label' => 'Supplemental Guidance',
                'sortable' => false,
                'type' => 'text'
            ),
            'externalReferences' => array(
                'initiallyVisible' => false,
                'label' => 'External References',
                'sortable' => false,
                'type' => 'text'
            ),
            'priorityCode' => array(
                'enumValues' => $this->getEnumValues('priorityCode'),
                'initiallyVisible' => false,
                'label' => 'Priority Code',
                'sortable' => true,
                'type' => 'enum'
            ),
            'catalog' => array(
                'initiallyVisible' => true,
                'label' => 'Catalog',
                'join' => array(
                    'model' => 'SecurityControlCatalog',
                    'relation' => 'Catalog',
                    'field' => 'name'
                ),
                'sortable' => true,
                'type' => 'text'
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
}
