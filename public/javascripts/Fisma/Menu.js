/**
 * Copyright (c) 2011 Endeavor Systems, Inc.
 *
 * This file is part of OpenFISMA.
 *
 * OpenFISMA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OpenFISMA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OpenFISMA.  If not, see {@link http://www.gnu.org/licenses/}.
 *
 * @author    Andrew Reeves <andrew.reeves@endeavorsystems.com>
 * @copyright (c) Endeavor Systems, Inc. 2011 {@link http://www.endeavorsystems.com}
 * @license   http://www.openfisma.org/content/license
 */

(function() {
    Fisma.Menu = {
        resolveOnClickObjects: function(obj) {
            if (obj.onclick && obj.onclick.fn) {
                obj.onclick.fn = Fisma.Util.getObjectFromName(obj.onclick.fn);
            }

            if (obj.submenu) {
                var groups = obj.submenu.itemdata;
                var i;
                for (i in groups) {
                    var group = groups[i];
                    var j;
                    for (j in group) {
                        var item = group[j];
                        Fisma.Menu.resolveOnClickObjects(item);
                    }
                }
            }
        },

        goTo: function(eType, eObject, param) {
            // create dialog
            var Dom = YAHOO.util.Dom,
                Event = YAHOO.util.Event,
                Panel = YAHOO.widget.Panel,
                contentDiv = document.createElement("div"),
                errorDiv = document.createElement("div"),
                form = document.createElement('form'),
                textField = $('<input type="text"/>').get(0),
                button = $('<input type="submit" value="Go"/>').get(0),
                table = $('<table class="fisma_crud"><tbody><tr><td>ID: </td><td></td><td></td></tr></tbody></table>');
            table.appendTo(form);
            $("td", table).get(1).appendChild(textField);
            $("td", table).get(2).appendChild(button);
            contentDiv.appendChild(errorDiv);
            contentDiv.appendChild(form);

            // Make Go button YUI widget
            button = new YAHOO.widget.Button(button);

            // Add event listener
            var fn = function(ev, obj) {
                Event.stopEvent(ev);
                var input = Number(obj.textField.value.trim());
                if (isFinite(input)) {
                    obj.errorDiv.innerHTML = "Navigating to ID " + input + "...";
                    window.location = obj.controller + "/view/id/" + input;
                } else { // input NaN
                    obj.errorDiv.innerHTML = "Please enter a single ID number.";
                }
            };
            param.textField = textField;
            param.errorDiv = errorDiv;
            Event.addListener(form, "submit", fn, param);

            // show the panel
            var panel = new Panel(Dom.generateId(), {modal: true});
            panel.setHeader("Go To " + param.model + "...");
            panel.setBody(contentDiv);
            panel.render(document.body);
            panel.center();
            panel.show();
            textField.focus();
        }
    };
}());
