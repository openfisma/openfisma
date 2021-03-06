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
 * A generator class to hold methods shared among the command-line tools.
 *
 * @author     Duy K. Bui
 * @copyright  (c) Endeavor Systems, Inc. 2012 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Fisma
 * @subpackage Fisma_Cli
 */
abstract class Fisma_Cli_AbstractGenerator extends Fisma_Cli_Abstract
{
    /**
     * Some organizations to randomly involve in the creation of sample data
     *
     * @var Doctrine_Collection
     */
    private $_sampleOrganizations;

    /**
     * Some sub categories to randomly involve in the creation of sample data
     *
     * @var Doctrine_Collection
     */
    private $_sampleSubCategories;

    /**
     * Some users to randomly involve in the creation of sample data
     *
     * @var Doctrine_Collection
     */
    private $_sampleUsers;

    /**
     * A sample upload
     *
     * @var Upload
     */
    private $_sampleUpload;

    /**
     * Get an Upload object to use as attachment for generated evidences, incidents... The object is NOT saved.
     *
     * The object is instantiated with default metadata and a real sample file in data/uploads.
     * The file is a PNG logo of OpenFISMA.
     *
     * @return Upload
     */
    protected function _getSampleAttachment($userId = 0)
    {
        if (empty($this->_sampleUpload)) {
            $this->_sampleUpload = new Upload();
            $this->_sampleUpload->fileHash = '7022767bf2f83dff89f5df9ea9570fd9ccf2c826';
            $this->_sampleUpload->fileName = 'sample.png';
            $this->_sampleUpload->User = $this->_getRandomUser();
            $this->_sampleUpload->uploadIp = '127.0.0.1';
            $this->_sampleUpload->description = 'This upload is generated by a CLI script.';
        }
        return $this->_sampleUpload;
    }

    /**
     * Return a random user object
     *
     * @return User
     */
    protected function _getRandomUser()
    {
        if (empty($this->_sampleUsers)) {
            // Get some sample users
            $this->_sampleUsers = Doctrine_Query::create()
                ->from('User u')
                ->where('u.username NOT LIKE ?', 'root')
                ->limit(50)
                ->execute();
            if (0 == count($this->_sampleUsers)) {
                throw new Fisma_Zend_Exception_User(
                    "Cannot generate sample data because the application has no users."
                );
            }
        }
        return $this->_sampleUsers[rand(0, count($this->_sampleUsers)-1)];
    }

    /**
     * Return a random organization object
     *
     * @return Fisma_Record
     */
    protected function _getRandomOrganization()
    {
        if (empty($this->_sampleOrganizations)) {
            // Get some organizations
            $this->_sampleOrganizations = Doctrine_Query::create()
                                          ->select('o.id')
                                          ->from('Organization o')
                                          ->leftJoin('o.System s')
                                          ->limit(50)
                                          ->execute();

            if (0 == count($this->_sampleOrganizations)) {
                throw new Fisma_Exception("Cannot generate sample data because the application has no organizations.");
            }
        }
        return $this->_sampleOrganizations[rand(0, count($this->_sampleOrganizations))];
    }

    /**
     * Generate a random phone number
     *
     * @return string
     */
    protected function _getRandomPhoneNumber()
    {
        return '(' . rand(100, 999) . ') ' . rand(100, 999) . '-' . rand(1000, 9999);
    }

    /**
     * Generate a random ipv4 address
     *
     * @return string
     */
    protected function _getRandomIpAddress()
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }
}
