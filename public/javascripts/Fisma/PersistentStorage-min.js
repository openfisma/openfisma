(function(){Fisma.PersistentStorage=function(a){Fisma.PersistentStorage.superclass.constructor.call(this,a)};YAHOO.extend(Fisma.PersistentStorage,Fisma.Storage,{_modified:null,get:function(a){return this._get(a)},set:function(a,b){if(this._modified===null){this._modified={}}this._modified[a]=b;return this._set(a,b)},init:function(a){for(var b in a){this._set(b,a[b])}},sync:function(d,e){var a=null,b=null,c=null;if(e){if(typeof(e)=="function"){a=e}else{if(e.success&&typeof(e.success)=="function"){a=e.success}}if(e.failure&&typeof(e.failure)=="function"){b=e.failure}if(e.scope){c=e.scope}}Fisma.Storage.onReady(function(){var h="/storage/sync/format/json",g=YAHOO.util.Selector.query("input[name^=csrf]"),i={scope:this,success:function(j){var k=YAHOO.lang.JSON.parse(j.responseText);if(k.status=="ok"){this.init(k.data);this._modified=null}if(a){a.call(c?c:this,j,k)}},failure:function(){if(b){b.call(c?c:this)}}},f=$.param({csrf:YAHOO.lang.isArray(g)&&g.length>0?g[0].value:"",namespace:this.namespace,updates:YAHOO.lang.JSON.stringify(this._modified),reply:d?YAHOO.lang.JSON.stringify(d):null});YAHOO.util.Connect.asyncRequest("POST",h,i,f)},this,true)}})})();