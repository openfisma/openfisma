Fisma.AutoComplete=function(){return{requestCount:0,resultsPopulated:false,init:function(b,f,e){var d=new YAHOO.widget.DS_XHR(e.xhr,e.schema);d.responseType=YAHOO.widget.DS_XHR.TYPE_JSON;d.maxCacheEntries=500;d.queryMatchContains=true;var c=new YAHOO.widget.AutoComplete(e.fieldId,e.containerId,d);c.maxResultsDisplayed=20;c.forceSelection=true;var a=document.getElementById(e.containerId+"Spinner");c.dataRequestEvent.subscribe(function(){a.style.visibility="visible";Fisma.AutoComplete.requestCount++});c.dataReturnEvent.subscribe(function(){Fisma.AutoComplete.requestCount--;if(0===Fisma.AutoComplete.requestCount){a.style.visibility="hidden"}});c.getInputEl().onclick=function(){if(Fisma.AutoComplete.resultsPopulated){c.expandContainer()}};c.containerPopulateEvent.subscribe(function(){Fisma.AutoComplete.resultsPopulated=true});c.generateRequest=function(g){return e.queryPrepend+g};c.formatResult=function(h,j,g){var i=(g)?g:"";i=PHP_JS().htmlspecialchars(i);return i};c.itemSelectEvent.subscribe(Fisma.AutoComplete.subscribe,{hiddenFieldId:e.hiddenFieldId,callback:e.callback})},subscribe:function(e,d,c){document.getElementById(c.hiddenFieldId).value=d[2][1]["id"];try{var b=Fisma.Util.getObjectFromName(c.callback);if("function"==typeof b){b()}}catch(a){}}}}();