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

require_once(realpath(dirname(__FILE__) . '/../../../Case/Unit.php'));

/**
 * Tests for the migration helper.
 *
 * These tests are weak. Although the database connection is mocked out, the tests themselves still rely quite a bit
 * on the respective implementations. E.g. if an implementation uses fetch() but could work equally well
 * with fetchAll(), then changing from fetch to fetchAll would break these tests. I'm not sure how to reasonably
 * avoid this without creating a very complex mock object (one that models the internal state of a database… yikes).
 *
 * Still, having coverage of these things is better than no coverage at all, so this is a jumping off point for
 * getting better coverage of migrations.
 *
 * @author     Mark E. Haase <mhaase@endeavorsystems.com>
 * @copyright  (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Test
 * @subpackage Test_Fisma
 */
class Test_Library_Fisma_Migration_Helper extends Test_Case_Unit
{
    /**
     * Test checking a table for existence.
     */
    public function testTableExists()
    {
        $successfulQueryResult = array(array('name' => 'FooTable'));
        $failedQueryResult = FALSE; // PDOStatement::fetch returns FALSE if there are no more results

        // Mock prepared statement
        $statement = $this->getMock('PDOStatement');
        $statement->expects($this->exactly(2))
                  ->method('fetch')
                  ->will($this->onConsecutiveCalls($successfulQueryResult, $failedQueryResult));

        // Mock DB
        $db = $this->getMock('Mock_Pdo');
        $db->expects($this->exactly(2))
           ->method('prepare')
           ->will($this->returnValue($statement));

        $helper = new Fisma_Migration_Helper($db);

        $this->assertTrue($helper->tableExists('FooTable'));
        $this->assertFalse($helper->tableExists('BarTable'));
    }

    /**
     * Test creating a table.
     */
    public function testCreateTable()
    {
        $db = $this->getMock('Mock_Pdo');
        $db->expects($this->once())
           ->method('exec')
           // PCRE flags (since nobody memorizes these) U=ungreedy, s=skip newlines, i=case insensitive
           ->with($this->matchesRegularExpression('/create\s+table.*foo.*id.*primary\s+key.*id/Usi'));

        $helper = new Fisma_Migration_Helper($db);

        $columns = array(
            'id' => "int NOT NULL AUTO_INCREMENT"
        );

        // The real meaning in this test is in the $db->with() call, so no assertions performed here.
        $helper->createTable('Foo', $columns, 'id');
    }

    /**
     * Test failure when creating a table.
     *
     * @expectedException Fisma_Zend_Exception_Migration
     */
    public function testCreateTableFailure()
    {
        $db = $this->getMock('Mock_Pdo');
        $db->expects($this->once())
           ->method('exec')
           ->will($this->returnValue(FALSE));

        $helper = new Fisma_Migration_Helper($db);
        $columns = array(
            'id' => "int NOT NULL AUTO_INCREMENT"
        );

        $helper->createTable('Foo', $columns, 'id');
    }

    /**
     * Test dropping a table.
     */
    public function testDropTable()
    {
        // Mock prepared statement
        $statement = $this->getMock('PDOStatement');
        $statement->expects($this->once())
                  ->method('execute')
                  ->with($this->arrayHasKey(':tableName'))
                  ->will($this->returnValue(0)); // PDOStatement::execute returns number of rows affected

        // Mock DB
        $db = $this->getMock('Mock_Pdo');
        $db->expects($this->once())
           ->method('prepare')
           // PCRE flags (since nobody memorizes these) U=ungreedy, s=skip newlines, i=case insensitive
           ->with($this->matchesRegularExpression('/drop\s+table/Usi'))
           ->will($this->returnValue($statement));

        // The real meaning in this test is in the with() calls, so no assertions performed here.
        $helper = new Fisma_Migration_Helper($db);
        $helper->dropTable('Foo');
    }

    /**
     * Test failure when dropping a table.
     *
     * @expectedException Fisma_Zend_Exception_Migration
     */
    public function testDropTableFailure()
    {
        // Mock prepared statement
        $statement = $this->getMock('PDOStatement');
        $statement->expects($this->once())
                  ->method('execute')
                  ->with($this->arrayHasKey(':tableName'))
                  ->will($this->returnValue(FALSE)); // PDOStatement::execute returns number of rows affected

        // Mock DB
        $db = $this->getMock('Mock_Pdo');
        $db->expects($this->once())
           ->method('prepare')
           // PCRE flags (since nobody memorizes these) U=ungreedy, s=skip newlines, i=case insensitive
           ->with($this->matchesRegularExpression('/drop\s+table/Usi'))
           ->will($this->returnValue($statement));

        $helper = new Fisma_Migration_Helper($db);
        $helper->dropTable('Foo');
    }
}
