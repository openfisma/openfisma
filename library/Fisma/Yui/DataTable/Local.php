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
 * A PHP wrapper for a YUI DataTable which has a local data source (i.e. an array)
 *
 * @author     Mark E. Haase
 * @copyright  (c) Endeavor Systems, Inc. 2009 {@link http://www.endeavorsystems.com}
 * @license    http://www.openfisma.org/content/license GPLv3
 * @package    Fisma
 * @subpackage Fisma_Yui
 */
class Fisma_Yui_DataTable_Local extends Fisma_Yui_DataTable_Abstract
{
    /**
     * A data source for the table
     *
     * @var Fisma_Yui_DataTable_Source_Interface
     */
    private $_data;

    /*
     * The message to send in the exception
     *
     * @const string
     */
    const LAYOUT_NOT_INSTANTIATED_ERROR = 'Layout has not been instantiated.';

    /**
     * An array of events for the data-table to listen for, and the javascript function name to tigger for each
     * i.e. eventListeners['checkboxClickEvent'] => 'myJavaScriptFunctionName'
     *
     * @var array
     */
    private $_eventListeners = array();

    /**
     * Set the table's data
     *
     * Fluent interface
     *
     * @param array $data
     */
    public function setData($data)
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * Render the datatable with HTML and/or Javascript
     *
     * @return string
     * @throws Fisma_Zend_Exception
     */
    public function render($layout = null)
    {
        if (!isset($layout)) {
            $layout = Zend_Layout::getMvcInstance();
        }
        if ($layout==null) {
            throw new Fisma_Zend_Exception(self::LAYOUT_NOT_INSTANTIATED_ERROR);
        } else {
            $view = $layout->getView();
        }

        $uniqueId = uniqid();

        $data = array(
            'containerId' => $uniqueId . "_container",
            'tableId' => $uniqueId . "_table",
            'columns' => $this->getColumns(),
            'data' => $this->_data,
            'columnDefinitions' => $this->_getYuiColumnDefinitions(),
            'responseSchema' => $this->_getYuiResponseSchema(),
            'eventListeners' => $this->_eventListeners,
            'groupBy' => $this->_groupBy,
            'registryName' => $this->getRegistryName()
        );

        return $view->partial('yui/data-table-local.phtml', 'default', $data);
    }

    /**
     * Construct a YUI representation of the response schema for a local data source
     *
     * @return array
     */
    private function _getYuiResponseSchema()
    {
        $fields = array();

        foreach ($this->getColumns() as $column) {
            $fields[] = array( 'key' => $column->getName(), 'parser' => $column->getParser() );
        }

        $responseSchema = array('fields' => $fields);

        return $responseSchema;
    }

    /**
     * Adds an event listener to the YUI data table, upon event, will call the target JavaScript function.
     *
     * @return void
     */
    public function addEventListener($yuiEventName, $javaScriptFunctionName)
    {
        $this->_eventListeners[$yuiEventName] = $javaScriptFunctionName;
    }

    /**
     * Return the number of records
     *
     * @return long
     */
    public function countData()
    {
        return count($this->_data);
    }
}
