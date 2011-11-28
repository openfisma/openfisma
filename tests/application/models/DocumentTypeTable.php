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

require_once(realpath(dirname(__FILE__) . '/../../Case/Unit.php'));

/**
 * Test_Application_Models_DocumentTypeTable 
 * 
 * @uses Test_Case_Unit
 * @package Test 
 * @copyright (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com> 
 * @license http://www.openfisma.org/content/license GPLv3
 */
class Test_Application_Models_DocumentTypeTable extends Test_Case_Unit
{
    /**
     * Check if getSearchableFields() returns a not-empty array 
     * 
     * @access public
     * @return void
     */
    public function testGetSearchableFields()
    {
        $searchableFields = DocumentTypeTable::getSearchableFields();

        $this->assertTrue(is_array($searchableFields));
        $this->assertNotEmpty($searchableFields);
    }

    /**
     * testGetAclFields 
     * 
     * @access public
     * @return void
     */
    public function testGetAclFields()
    {
        $this->assertTrue(is_array(DocumentTypeTable::getAclFields()));
    }

    /**
     * testGetSearchIndexQuery 
     * 
     * @access public
     * @return void
     */
    public function testGetSearchIndexQuery()
    {
        $sampleQ = Doctrine_Query::create()->from('System s');
        $q = DocumentTypeTable::getSearchIndexQuery($sampleQ, array('DocumentType' => 'document_type'));
        $this->assertEquals('Doctrine_Query', get_class($q));
        $this->assertEquals(
            "SELECT document_type.id AS id, document_type.name AS name, IF(document_type.required = 1, 'yes', 'no') AS"
            . " required FROM System s",
            $q->getDql()
        );
    }

    /**
     * Make sure getAllRequiredDeocumentTypeQuery() returns the expected query
     * 
     * @return void
     */
    public function testGetAllRequiredDocumentTypeQuery()
    {
        $query = DocumentTypeTable::getAllRequiredDocumentTypeQuery();
        $query = $query->getDql();
        $expectedQuery = 'FROM DocumentType dt WHERE dt.required = ?';
        $this->assertContains($expectedQuery, $query);
    }
}
