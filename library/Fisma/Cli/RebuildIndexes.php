<?php
/**
 * Copyright (c) 2010 Endeavor Systems, Inc.
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
 * A command-line-oriented class for rebuilding search indexes
 * 
 * @author     Mark E. Haase
 * @copyright  (c) Endeavor Systems, Inc. 2010 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Fisma
 * @subpackage Fisma_Cli
 */
class Fisma_Cli_RebuildIndexes extends Fisma_Cli_Abstract
{
    /**
     * Configure the arguments accepted for this CLI program
     * 
     * @return array An array containing getopt long syntax
     */
    public function getArgumentsDefinitions()
    {
        return array(
            'model|m=w' => "Name of model to rebuild index for. If not specified, then rebuild ALL model's indexes."
        );
    }    
    
    /**
     * Drop the index specified on the command line, or if none is specified, drop and rebuild ALL indexes
     */
    protected function _run()
    {
        $indexManager = new Fisma_Search_IndexManager;
     
        // If one model specified, then rebuild that model only. Otherwise rebuild ALL model
        $modelName = $this->getOption('model');
        
        if (is_null($modelName)) {
            $searchableClasses = $indexManager->getSearchableClasses(Fisma::getPath('model'));            
        } else {
            $searchableClasses = array($modelName);
        }

        // Do the actual indexing
        foreach ($searchableClasses as $searchableClass) {
            echo "Indexing: $searchableClass\n";

            $indexManager->rebuildIndexForClass($searchableClass);
        }
    }
}
