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

/**
 * Fisma_Cli_GenerateSystems 
 * 
 * @uses Fisma_Cli_Abstract
 * @package Fisma_Cli 
 * @copyright (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @author Josh Boyd <joshua.boyd@endeavorsystems.com> 
 * @license http://www.openfisma.org/content/license GPLv3
 */
class Fisma_Cli_GenerateSystems extends Fisma_Cli_AbstractGenerator
{
    /**
     * Configure the arguments accepted for this CLI program
     *
     * @return array An array containing getopt long syntax
     */
    public function getArgumentsDefinitions()
    {
        return array(
            'number|n=i' => "Number of system objects to generate"
        );
    }

    /**
     * Create systems 
     * 
     * @access protected
     * @return void
     */
    protected function _run()
    {
        Fisma::setNotificationEnabled(false);
        Fisma::setListenerEnabled(false);

        $inMemoryConfig = new Fisma_Configuration_Array();
        Fisma::setConfiguration($inMemoryConfig, true);

        $numSystems = $this->getOption('number');

        if (is_null($numSystems)) {
            throw new Fisma_Zend_Exception_User("Number is a required argument.");

            return;
        }

        $systems = array();

        // Some enumerations to randomly pick values from
        $phase = array('initiation', 'development', 'implementation', 'operations', 'disposal');
        $confidentiality = array('NA', 'LOW', 'MODERATE', 'HIGH');
        $integrity = array('LOW', 'MODERATE', 'HIGH');
        $availability = array('LOW', 'MODERATE', 'HIGH');

        // Progress bar for console progress monitoring
        $generateProgressBar = $this->_getProgressBar($numSystems);
        $generateProgressBar->update(0, "Generate Systems");

        for ($i = 1; $i <= $numSystems; $i++) {
            $system = array();
            $system['name'] = trim(Fisma_String::loremIpsum(1));
            $system['nickname'] = trim(strtoupper(Fisma_String::loremIpsum(1))) . $i;
            $system['sdlcphase'] = $phase[array_rand($phase)];
            $system['description'] = Fisma_String::loremIpsum(rand(100, 500));
            $system['confidentiality'] = $confidentiality[array_rand($confidentiality)];
            $system['integrity'] = $integrity[array_rand($integrity)];
            $system['availability'] = $availability[array_rand($availability)];

            $systems[] = $system;
            unset($system);

            $generateProgressBar->update($i);
        }

        print "\n";

        $saveProgressBar = $this->_getProgressBar($numSystems);
        $saveProgressBar->update(0, "Save Systems");

        $currentSystem = 0;
        $systemType = Doctrine::getTable('OrganizationType')->findOneByNickname('system', Doctrine::HYDRATE_ARRAY);

        $systemTypeIds = Doctrine::getTable('SystemType')->findAll()->toKeyValueArray('id', 'id');
        $systemIds = Doctrine_Query::create()
                     ->from('System s')
                     ->where('s.aggregateSystemId is null')
                     ->execute()
                     ->toKeyValueArray('id', 'id');

        try {
            Doctrine_Manager::connection()->beginTransaction();

            foreach ($systems as $system) {
                $s = new System();
                $s->merge($system);

                $s->systemTypeId = array_rand($systemTypeIds);
                $s->aggregateSystemId = array_rand($systemIds);

                $s->Organization = new Organization();

                $s->Organization->orgTypeId = $systemType['id'];
                $s->Organization->merge($system);
                $s->save();
 
                $s->Organization->getNode()->insertAsLastChildOf($this->_getRandomOrganization());
                $s->Organization->save();

                $this->_setRoleOrganization($s->Organization->id);
                $s->free();
                unset($s);

                $currentSystem++;
                $saveProgressBar->update($currentSystem);
            }

            Doctrine_Manager::connection()->commit();
        } catch (Exception $e) {
            Doctrine_Manager::connection()->rollBack();
            throw $e;
        }
    }

    /**
     * Assign the generated organzation to an admin user if it exists
     * 
     * @return void
     */
    private function _setRoleOrganization($organizationId)
    {
        $adminRole = Doctrine::getTable('Role')->findOneByNickName('ADMIN', Doctrine::HYDRATE_ARRAY);
        $userRole =  Doctrine::getTable('UserRole')->findOneByRoleId($adminRole['id'], Doctrine::HYDRATE_ARRAY);
        if (empty($adminRole) || empty($userRole)) {
            return;
        }

        $userRoleOrganization = New UserRoleOrganization();
        $userRoleOrganization->userRoleId = $userRole['userRoleId'];
        $userRoleOrganization->organizationId = $organizationId;
        
        $userRoleOrganization->Save();
        $userRoleOrganization->free();
        unset($userRoleOrganization); 
    }
}
