Fisma.Role={rolePrivChanges:{},dataTableCheckboxClick:function(f){var g=f.target;var d=this.getColumn(g);var b=d.key;var c=this.getRow(g).childNodes[1].childNodes[0].childNodes[0];var e=$(c).text();var a={roleName:b,privilegeId:e,newValue:g.checked};Fisma.Role.rolePrivChanges[b+e]=a;YAHOO.util.Dom.get("rolePrivChanges").value=YAHOO.lang.JSON.stringify(Fisma.Role.rolePrivChanges)}};