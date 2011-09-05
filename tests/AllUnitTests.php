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

require_once(realpath(dirname(__FILE__) . '/Harness/Unit.php'));

/**
 * This class is the controller which executes all of the project's unit tests.
 * 
 * Unit tests are defined as tests which cover very small areas of code with as few external dependencies as
 * possible. For example, controllers and database interaction should not be covered in unit tests.
 * 
 * @author     Mark E. Haase <mhaase@endeavorsystems.com>
 * @copyright  (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Test
 */
class AllUnitTests
{
    /**
     * PhpUnit expects a static method called suite(), which means our test runners each have to be a facade class like
     * this one.
     * 
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {        
        $testHarness = new Test_Harness_Unit('OpenFISMA: ' . get_class());
        
        return $testHarness->getTestSuite();
    }
}
