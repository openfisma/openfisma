Fisma.Incident={commentTable:null,attachArtifactCallback:function(a){window.location.href=window.location.href},commentCallback:function(f,b){var d=this;var c={timestamp:f.createdTs,username:f.username,comment:f.comment};this.commentTable=Fisma.Registry.get("comments");this.commentTable.addRow(c);this.commentTable.sortColumn(this.commentTable.getColumn(0),YAHOO.widget.DataTable.CLASS_DESC);var a=new Fisma.Blinker(100,6,function(){d.commentTable.highlightRow(0)},function(){d.commentTable.unhighlightRow(0)});a.start();var e=document.getElementById("incidentCommentsCount").firstChild;e.nodeValue++;b.hide();b.destroy()},getIncidentStepParentElement:function(b){var c=b.parentNode.parentNode.parentNode;var a=1;if(!(a==c.nodeType&&"TR"==c.tagName)){throw"Cannot locate the parent element for this incident step."}return c},getIncidentStepNumber:function(e){var d=e.firstChild;var b=1;if(!(b==d.nodeType&&"TD"==d.tagName)){throw"Cannot locate the table data (td) element for this incident step."}var a=d.firstChild.nodeValue;var c=a.match(/\d+/);if(c.length!=1){throw"Not able to locate the step number in the incident step label."}return c[0]},renumberAllIncidentSteps:function(b){var c=YAHOO.util.Dom.getElementsByClassName("incidentStep","tr",b);var a=1;for(var d in c){var e=c[d];e.firstChild.firstChild.nodeValue="Step "+a+":";a++}},addIncidentStepAbove:function(c){var b=this.getIncidentStepParentElement(c);var d=this.generateTextareaId(b.parentNode);var a=this.generateIncidentStep(b,d);b.parentNode.insertBefore(a,b);tinyMCE.execCommand("mceAddControl",false,d);this.renumberAllIncidentSteps(b.parentNode);return false},addIncidentStepBelow:function(c){var b=this.getIncidentStepParentElement(c);var d=this.generateTextareaId(b.parentNode);var a=this.generateIncidentStep(b,d);if(b.nextSibling){b.parentNode.insertBefore(a,b.nextSibling)}else{b.parentNode.appendChild(a)}tinyMCE.execCommand("mceAddControl",false,d);this.renumberAllIncidentSteps(b.parentNode);return false},removeIncidentStep:function(b){var a=this.getIncidentStepParentElement(b);a.parentNode.removeChild(a);this.renumberAllIncidentSteps(a.parentNode);return false},generateIncidentStep:function(p,g){var o=p.cloneNode(false);var s=p.parentNode;var b=document.createElement("td");b.innerHTML="Step : ";o.appendChild(b);var n=document.createElement("td");o.appendChild(n);var e=YAHOO.util.Dom.getLastChild(p);var t=YAHOO.util.Dom.getFirstChild(e);var i=t.cloneNode(true);var r=YAHOO.util.Dom.getNextSibling(t);var a=r.cloneNode(true);n.appendChild(i);n.appendChild(a);var q=document.createElement("p");q.innerHTML="Description: ";var h=YAHOO.util.Dom.getNextSibling(r);var j=YAHOO.util.Dom.getFirstChild(h);var l=YAHOO.util.Dom.getAttribute(j,"rows");var m=YAHOO.util.Dom.getAttribute(j,"cols");var d=YAHOO.util.Dom.getAttribute(j,"name");var k;if(YAHOO.env.ua.ie){k=document.createElement("<textarea name='"+d+"'></textarea>")}else{k=document.createElement("textarea")}k.setAttribute("id",g);k.setAttribute("rows",l);k.setAttribute("cols",m);k.setAttribute("name",d);q.appendChild(k);n.appendChild(q);var c=YAHOO.util.Dom.getNextSibling(h);var f=c.cloneNode(true);n.appendChild(f);return o},generateTextareaId:function(c){var b=YAHOO.util.Dom.getElementsByClassName("incidentStep","tr",c);var a=1+b.length;var d="textareaid"+a;return d}};