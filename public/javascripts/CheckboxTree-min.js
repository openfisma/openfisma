YAHOO.namespace("fisma.CheckboxTree");YAHOO.fisma.CheckboxTree.rootNode;YAHOO.fisma.CheckboxTree.handleClick=function(j,c){if(c.altKey){return}var g=j.parentNode;var k=g.nextSibling.childNodes[0];if(k.getAttribute("nestedLevel")>j.getAttribute("nestedLevel")){var a=j.getAttribute("nestedlevel");var d=new Array();var l=true;var b=g.nextSibling;var h=b.childNodes[0];while(h.getAttribute("nestedLevel")>a){if(!h.checked){l=false}d.push(h);if(b.nextSibling){b=b.nextSibling;h=b.childNodes[0]}else{break}}if(l){j.checked=false}else{j.checked=true}for(var e in d){var f=d[e];if(l){f.checked=false}else{f.checked=true}}}};