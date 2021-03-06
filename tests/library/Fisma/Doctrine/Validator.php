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
 * test suite for /library/Fisma/Doctrine/Validator.php
 *
 * @author     Duy K. Bui <duy.bui@endeavorsystems.com>
 * @copyright  (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Test
 * @subpackage Test_Library
 */
class Test_Library_Fisma_Doctrine_Validator extends Test_Case_Unit
{
    /**
     * test getValidator() with default Doctrine's validators
     *
     * @return void
     */
    public function testGetDefaultValidator()
    {
        $this->assertEquals('Doctrine_Validator_Ip', get_class(Fisma_Doctrine_Validator::getValidator('IP')));
    }

    /**
     * test getValidator() with custom Fisma_Doctrine's validators
     * 
     * @return void
     */
    public function testGetCustomValidator()
    {
        $this->assertEquals('Fisma_Doctrine_Validator_Ip',
                            get_class(Fisma_Doctrine_Validator::getValidator('Fisma_Doctrine_Validator_Ip')));
    }

    /**
     * test getValidator() with invalid input
     * 
     * @return void
     */
    public function testGetUnsupportedValidator()
    {
        $this->setExpectedException('Doctrine_Exception', 'Validator named \'\' not available.');
        Fisma_Doctrine_Validator::getValidator('');
    }
}

