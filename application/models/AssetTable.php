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
 * AssetTable 
 * 
 * @uses Fisma_Doctrine_Table
 * @package Model 
 * @copyright (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com> 
 * @license http://www.openfisma.org/content/license GPLv3
 */
class AssetTable extends Fisma_Doctrine_Table implements Fisma_Search_Searchable
{
    /**
     * Implement the interface for Searchable
     */
    public function getSearchableFields()
    {
        return array (
            'name' => array(
                'displayName' => 'Name',
                'sortable' => true,
                'type' => 'text'
            ), 
            'source' => array(
                'displayName' => 'Source',
                'sortable' => true,
                'type' => 'text'
            ), 
            'createdTs' => array(
                'displayName' => 'Creation Date',
                'sortable' => true,
                'type' => 'datetime'
            ), 
            'modifiedTs' => array(
                'displayName' => 'Modification Date',
                'sortable' => true,
                'type' => 'datetime'
            ), 
            'addressIp' => array(
                'displayName' => 'IP Address',
                'sortable' => true,
                'type' => 'text'
            ),
            'addressPort' => array(
                'displayName' => 'IP Port',
                'sortable' => true,
                'type' => 'integer'
            ),
            'network' => array(
                'displayName' => 'Network',
                'join' => array(
                    'relation' => 'Network', 
                    'field' => 'nickname'
                ),
                'sortable' => true,
                'type' => 'text'
            ),
            'system' => array(
                'displayName' => 'System',
                'join' => array(
                    'relation' => 'Organization', 
                    'field' => 'nickname'
                ),
                'sortable' => true,
                'type' => 'text'
            ),
            'product' => array(
                'displayName' => 'Product',
                'join' => array(
                    'relation' => 'Product', 
                    'field' => 'name'
                ),
                'sortable' => false,
                'type' => 'text'
            )
        );
    }
}
