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
 * 
 * @author    Andrew Reeves <andrew.reeves@endeavorsystems.com>
 * @copyright (c) Endeavor Systems, Inc. 2012 (http://www.endeavorsystems.com)
 * @license   http://www.openfisma.org/content/license
 */

(function() {
    /**
     * Manages the IR workflow editor using dynamic client-side code.
     *
     * @param {Array} data.steps Array of object literals containing the properties for each of the initial workflow steps.
     * @param {Object} data.roles Object literal mapping role IDs to their nicknames.
     * @param {String} templateId ID of the DOM element containing the template to use when adding new workflow steps.
     * @class IncidentWorkflow
     * @constructor
     */
    var FIW = function(data, templateId) {
        this._stepTemplate = $("#" + templateId + " tr").first();
        this._addOptionsToRoleSelect(data.roles);
        var lastTr = $("table.fisma_crud tr").first().siblings().last(),
            that = this;
        $.each(data.steps, function(index, value) {
            that.addStepBelow(lastTr, value);
            lastTr = lastTr.next();
        });
    };
    FIW.prototype = {
        /**
         * @property _stepTemplate
         * @description A jQuery collection referring to the step template root node.
         * @protected
         * @type jQuery
         */
        _stepTemplate: null,

        /**
         * @method _addOptionsToRoleSelect
         * @description Populate the step template's select element with roles.
         * @protected
         * @param {Object} Associative array of roleIds to nicknames.
         */
        _addOptionsToRoleSelect: function(roleData) {
            var select = $("select", this._stepTemplate);
            select.append("<option value=''></option>");
            $.each(roleData, function(key, value) {
                select.append("<option value='" + key + "'>" + value + "</option>");
            });
        },

        /**
         * @method _renumberSteps
         * @description Renumber the step labels in the left hand column.  Used to correct numbering after adding or removing a step.
         * @protected
         */
        _renumberSteps: function() {
            // The selector may seem overly specific, but all parts ARE needed
            $("table.fisma_crud tr.incidentStep > td:first-child").text(function(i) { return "Step " + (i+1); });
        },

        /**
         * @method addStepAbove
         * @description Add empty step above the provided TR element.  The step may optionally be populated with the provided data.
         * @public
         * @param {String|HTMLElement|jQuery} tr Element above which to place the new step.
         * @param {Object} data (Optional) Data with which to populate the new step.
         */
        addStepAbove: function (tr, data) {
            this.addStepBelow($(tr).prev().get(0), data);
            this._renumberSteps();
        },

        /**
         * @method addStepBelow
         * @description Add empty step below the provided TR element.  The step may optionally be populated with the provided data.
         * @public
         * @param {String|HTMLElement|jQuery} tr Element below which to place the new step.
         * @param {Object} data (Optional) Data with which to populate the new step.
         */
        addStepBelow: function (tr, data) {
            // clone new TR from template and set up values
            var newTr = this._stepTemplate.clone(),
                buttons = $("button", newTr).get(),
                textareaId = tinyMCE.DOM.uniqueId(),
                newTextarea = $('<textarea name="stepDescription[]" rows="8" cols="100" />'),
                fn;
            $("span.templateDescription", newTr).replaceWith(newTextarea);
            newTextarea.attr("id", textareaId);
            if (data) {
                $("input", newTr).val(data.name);
                $("select", newTr).val(data.roleId);
                newTextarea.val(data.description);
            }

            fn = function() { this.addStepAbove(newTr); };
            new YAHOO.widget.Button(buttons[0], {onclick: {fn: fn, scope: this}});

            fn = function() { this.addStepBelow(newTr); };
            new YAHOO.widget.Button(buttons[1], {onclick: {fn: fn, scope: this}});

            fn = function() { this.removeStep(newTr); };
            new YAHOO.widget.Button(buttons[2], {onclick: {fn: fn, scope: this}});

            // add it to the table
            $(tr).after(newTr);
            // tell tinyMCE to render it now
            tinyMCE.execCommand ('mceAddControl', false, textareaId);
            this._renumberSteps();
        },

        /**
         * @method removeStep
         * @description Remove step of the provided TR element from the workflow.
         * @public
         * @param {String|HTMLElement|jQuery} tr Element to be removed.
         */
        removeStep: function(tr) {
            $(tr).remove();
            this._renumberSteps();
        }
    };
    Fisma.IncidentWorkflow = FIW;
}());
