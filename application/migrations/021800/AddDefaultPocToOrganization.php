<?php
/**
 * Copyright (c) 2012 Endeavor Systems, Inc.
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
 * Set the max upload file size for the whole application, for OFJ-1824.
 *
 * @author     Mark Ma <mark.ma@reyosoft.com>
 * @copyright  (c) Endeavor Systems, Inc. 2012 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Migration
 */
class Application_Migration_021800_AddDefaultPocToOrganization extends Fisma_Migration_Abstract
{
    /**
     * Add an int collumn
     */
    public function migrate()
    {
        $this->message("Adding pocid field to organization table");

        $option = "bigint(20) DEFAULT NULL";

        $this->getHelper()->addColumn('organization', 'pocid', $option, 'systemid');
        $this->getHelper()->addForeignKey('organization', 'pocid', 'poc', 'id');
    }
}
