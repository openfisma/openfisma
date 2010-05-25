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

require_once(realpath(dirname(__FILE__) . '/../../../FismaUnitTest.php'));

/**
 * This is a stub for XssListener to mark test coverage
 * 
 * @author     Ben Zheng <benzheng@users.sourceforge.net>
 * @copyright  (c) Endeavor Systems, Inc. 2010 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Test
 * @subpackage Test_Model
 * @version    $Id$
 */
class Test_Application_Models_Listener_XssListener extends Test_FismaUnitTest
{
    /**
     * Test purification of plain text fields to prevent XSS injection
     */
    public function testXssListenerPurifiesPlainTextField()
    {
        // Use Incident.reporterFirstName as a sample field which we know has a plaintext purifier
        $incident = new Incident();
        
        $incident->reporterFirstName = "<script type='text/javascript'>alert('hello')</script>";
        
        $incident->save();
        
        // The input is "safe" if there are no angle brackets left in the field
        $this->assertNotContains('<', $incident->reporterFirstName);
        $this->assertNotContains('>', $incident->reporterFirstName);
    }
    
    /**
     * Test purification of html fields to prevent XSS injection
     */
    public function testXssListenerPurifiesHtmlField()
    {
        // Use Incident.additionalInfo as a sample field which we know has an HTML purifier
        $incident = new Incident();
        
        $incident->additionalInfo = "<script type='text/javascript'>alert('hello')</script>";
        
        $incident->save();
        
        // HTML purifier should blank out the entire string, since it is all malicious
        $this->assertEquals('', trim($incident->additionalInfo));
    }
}
