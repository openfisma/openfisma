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

/**
 * A subclass of Doctrine_Record which adds support for getting the original value of a field after the object has been
 * persisted.
 *
 * Base Doctrine_Record does not provide a reliable means to do this. It has getLastModified(true) which returns
 * the value of a field, but if you update a field more than once before persisting, then you can never get the
 * original value back.
 *
 * @author     Mark E. Haase
 * @copyright  (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Fisma
 * @subpackage Fisma_Doctrine_Record
 */
abstract class Fisma_Doctrine_Record extends Doctrine_Record
{
    /**
     * Store the original values of this record.
     *
     * @var array
     */
    private $_originalValues = array();

    /**
     * A dictionary of validation messages
     *
     * Zend_Config
     */
    static private $_validationMessages;

    /**
     * Array of pending links in format alias => keys to be executed after save
     *
     * @var array $_pendingLinks
     */
    protected $_pendingLinks = array();

    /**
     * override Doctrine_Record->link() so as to store pendingLinks
     *
     * @param string $alias     related component alias
     * @param array $ids        the identifiers of the related records
     * @param boolean $now      wether or not to execute now or set pending
     * @return Doctrine_Record  this object (fluent interface)
     */
    public function link($alias, $ids, $now = false)
    {
        foreach ($ids as $id) {
            $this->_pendingLinks[$alias][$id] = true;
        }

        parent::link($alias, $ids, $now);
    }

    /**
     * returns Doctrine_Record instances which need to be linked (adding the relation) on save
     *
     * @return array $pendingLinks
     */
    public function getPendingLinks()
    {
        return $this->_pendingLinks;
    }

    /**
     * Get an array of modified fields with their original values
     *
     * @param string $fieldName
     * @return mixed May return null if no original value was captured
     */
    public function getOriginalValue($fieldName)
    {
        return array_key_exists($fieldName, $this->_originalValues) ? $this->_originalValues[$fieldName] : null;
    }

    /**
     * Hook into the setter. This is the only place where we can see all data.
     */
    protected function _set($fieldName, $value, $load = true)
    {
        parent::_set($fieldName, $value, $load);

        if (!array_key_exists($fieldName, $this->_originalValues) && array_key_exists($fieldName, $this->_oldValues)) {
            $this->_originalValues[$fieldName] = $this->_oldValues[$fieldName];
        }
    }

    /**
     * Generate a better validation error message than Doctrine's default by overriding the parent class method
     *
     * @return string $message
     */
    public function getErrorStackAsString()
    {
        $errorStack = $this->getErrorStack();

        if (count($errorStack)) {
            $count = count($errorStack);

            foreach ($errorStack as $field => $errors) {
                foreach ($errors as $error) {
                    /**
                     * Custom validators are returned as objects, not strings. So we need to convert objects into
                     * strings (by class name) so that a validation message can be generated
                     */
                    if (is_object($error)) {
                        $errorName = get_class($error);
                    } else {
                        $errorName = $error;
                    }

                    $message = $this->_getCustomValidationErrorMessage($errorName, $field)
                             . "\n";
                }
            }

            return $message;
        } else {
            return false;
        }
    }

    /**
     * Override parent setup
     *
     * @access public
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->addListener(new ReplaceInvalidCharactersListener(), 'ReplaceInvalidCharactersListener');
        $this->addListener(new XssListener(), 'XssListener');
    }

    /**
     * Override parent isValid
     *
     * @access public
     * @return void
     */
    public function isValid($deep = false, $hooks = true)
    {

        if ( ! $this->_table->getAttribute(Doctrine::ATTR_VALIDATE)) {
            return true;
        }

        if ($this->_state == self::STATE_LOCKED || $this->_state == self::STATE_TLOCKED) {
            return true;
        }

        if ($hooks) {
            $this->invokeSaveHooks('pre', 'save');
            $this->invokeSaveHooks('pre', $this->exists() ? 'update' : 'insert');
        }

        // Clear the stack from any previous errors.
        $this->getErrorStack()->clear();

        // Run validation process
        $event = new Doctrine_Event($this, Doctrine_Event::RECORD_VALIDATE);
        $this->preValidate($event);
        $this->getTable()->getRecordListener()->preValidate($event);

        if ( ! $event->skipOperation) {

            // Using Fisma_Doctrine_Validator which suppresses the warning message of FileNotFound.
            $validator = new Fisma_Doctrine_Validator();
            $validator->validateRecord($this);
            $this->validate();
            if ($this->_state == self::STATE_TDIRTY || $this->_state == self::STATE_TCLEAN) {
                $this->validateOnInsert();
            } else {
                $this->validateOnUpdate();
            }
        }

        $this->getTable()->getRecordListener()->postValidate($event);
        $this->postValidate($event);

        $valid = $this->getErrorStack()->count() == 0 ? true : false;
        if ($valid && $deep) {
            $stateBeforeLock = $this->_state;
            $this->_state = $this->exists() ? self::STATE_LOCKED : self::STATE_TLOCKED;

            foreach ($this->_references as $reference) {
                if ($reference instanceof Doctrine_Record) {
                    if ( ! $valid = $reference->isValid($deep)) {
                        break;
                    }
                } else if ($reference instanceof Doctrine_Collection) {
                    foreach ($reference as $record) {
                        if ( ! $valid = $record->isValid($deep)) {
                            break;
                        }
                    }
                }
            }
            $this->_state = $stateBeforeLock;
        }

        return $valid;
    }
    /**
     * Get a customized error validation message that is suitable for displaying to an end user
     *
     * @see _customValidationErrorMessage
     *
     * @param string $error Doctrine's name for the validation error
     * @param string $field The name of the field which failed validation
     * @return string
     */

    private function _getCustomValidationErrorMessage($error, $field)
    {
        if (!self::$_validationMessages) {
            $messageFile = realpath(Fisma::getPath('config') . '/validation.yml');

            // ZF's YAML parser stinks… Doctrine's supports string folding.
            self::$_validationMessages = Doctrine_Parser_YamlSf::load($messageFile);
        }

        // Include the logical name in the error message, or else use the physical name
        $columnName = $this->getTable()->getColumnName($field);
        $column = $this->getTable()->getColumnDefinition($columnName);

        if (isset($column['extra']['logicalName'])) {
            $userFriendlyName = $column['extra']['logicalName'];
        } else {
            $userFriendlyName = $field;
        }

        // Lookup the value which failed
        $invalidValue = $this->$field;

        if (isset(self::$_validationMessages['messages'][$error])) {
            $errorTemplate = self::$_validationMessages['messages'][$error];

            $specifiers = array('%f', '%v');
            $specifierExpansions = array($userFriendlyName, $invalidValue);

            $errorMessage = str_replace($specifiers, $specifierExpansions, $errorTemplate);
        } else {
            $errorMessage = "$userFriendlyName failed a validation: $error";
        }

        return $errorMessage;
    }

    /**
     * Returns a reference to the default cache
     *
     * @access protected
     * @return void
     */
    protected function _getCache()
    {
        $bootstrap = (Zend_Controller_Front::getInstance()->getParam('bootstrap')) ?
                        Zend_Controller_Front::getInstance()->getParam('bootstrap') : false;

        return ($bootstrap) ? $bootstrap->getResource('cachemanager')->getCache('default') : null;
    }
}
