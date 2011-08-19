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

require_once(realpath(dirname(__FILE__) . '/../../../../Case/Unit.php'));

/**
 * Test_Library_Fisma_Zend_Exception_InvalidFileFormat
 * 
 * @uses Test_Case_Unit
 * @package Test_Library_Fisma_Zend_Exception 
 * @copyright (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com> 
 * @license http://www.openfisma.org/content/license GPLv3
 */
class Test_Library_Fisma_Zend_Exception_InvalidFileFormat extends Test_Case_Unit
{
    /**
     * testInvalidFileFormat
     * 
     * @access public
     * @return void
     * @expectedException Fisma_Zend_Exception_InvalidFileFormat
     */
    public function testInvalidFileFormat()
    {
        throw new Fisma_Zend_Exception_InvalidFileFormat();
    }
}
