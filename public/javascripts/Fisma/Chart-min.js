Fisma.Chart={CHART_CREATE_SUCCESS:1,CHART_CREATE_FAILURE:2,CHART_CREATE_EXTERNAL:3,globalSettingsDefaults:{fadingEnabled:false,usePatterns:false,barShadows:false,barShadowDepth:3,dropShadows:false,gridLines:false,pointLabels:false,pointLabelsOutline:false,showDataTable:false},patternURLs:["/images/pattern-horizontal.png","/images/pattern-diamonds.png","/images/pattern-backbg-whitedots.png","/images/pattern-diagonal-45degree.png","/images/pattern-bubbles.png","/images/pattern-checkers.png","/images/pattern-diagonal-135degree.png","/images/pattern-diagonal-bricks.png"],chartsOnDOM:{},isIE:(window.ActiveXObject)?true:false,hasHookedPostDrawSeries:false,createJQChart_asynchReturn:function(a,c,b){if(c){if(c.results[0]){b=Fisma.Chart.mergeExtrnIntoParamObjectByInheritance(b,c)}else{Fisma.Chart.showMsgOnEmptyChart(b);throw"Error - Chart creation failed due to data source error at "+b.lastURLpull}Fisma.Chart.showMsgOnEmptyChart(b);if(typeof b.chartData==="undefined"){Fisma.Chart.showMsgOnEmptyChart(b);var d='Chart Error - The remote data source for chart "';d+=b.uniqueid+'" located at '+b.lastURLpull;d+=" did not return data to plot on a chart";throw d}else{if(b.chartData.length===0){Fisma.Chart.showMsgOnEmptyChart(b)}}return Fisma.Chart.createJQChart(b)}else{Fisma.Chart.showMsgOnEmptyChart(b);throw"Error - Chart creation failed due to data source error at "+b.lastURLpull}},createJQChart:function(e){var d={concatXLabel:false,nobackground:true,drawGridLines:false,pointLabelStyle:"color: black; font-size: 12pt; font-weight: regular",pointLabelAdjustX:-3,pointLabelAdjustY:-7,AxisLabelX:"",AxisLabelY:"",DataTextAngle:-30};e=jQuery.extend(true,d,e);if(document.getElementById(e.uniqueid)===false){throw"createJQChart Error - The target div/uniqueid does not exists"+e.uniqueid}Fisma.Chart.setChartWidthAttribs(e);Fisma.Chart.makeElementVisible(e.uniqueid+"loader");if(e.externalSource){document.getElementById(e.uniqueid).innerHTML="Loading chart data...";var c=e.externalSource;if(!e.oldExternalSource){e.oldExternalSource=e.externalSource}e.externalSource=undefined;e=Fisma.Chart.buildExternalSourceParams(e);c+=String(e.externalSourceParams).replace(/ /g,"%20");e.lastURLpull=c;var f=new YAHOO.util.DataSource(c);f.responseType=YAHOO.util.DataSource.TYPE_JSON;f.responseSchema={resultsList:"chart"};var b={success:Fisma.Chart.createJQChart_asynchReturn,failure:Fisma.Chart.createJQChart_asynchReturn,argument:e};f.sendRequest("",b);return Fisma.Chart.CHART_CREATE_EXTERNAL}document.getElementById(e.uniqueid).innerHTML="";document.getElementById(e.uniqueid).className="";document.getElementById(e.uniqueid+"toplegend").innerHTML="";if(typeof e.barMargin!=="undefined"){e=jQuery.extend(true,e,{seriesDefaults:{rendererOptions:{barMargin:e.barMargin}}});e.barMargin=undefined}if(typeof e.legendLocation!=="undefined"){e=jQuery.extend(true,e,{legend:{location:e.legendLocation}});e.legendLocation=undefined}if(typeof e.legendRowCount!=="undefined"){e=jQuery.extend(true,e,{legend:{rendererOptions:{numberRows:e.legendRowCount}}});e.legendRowCount=undefined}e.chartData=Fisma.Chart.forceIntegerArray(e.chartData);document.getElementById(e.uniqueid+"holder").style.display="";Fisma.Chart.makeElementInvisible(e.uniqueid+"holder");document.getElementById(e.uniqueid+"loader").style.position="absolute";document.getElementById(e.uniqueid+"loader").finnishFadeCallback=new Function("Fisma.Chart.fadeIn('"+e.uniqueid+"holder', 500);");Fisma.Chart.fadeOut(e.uniqueid+"loader",500);Fisma.Chart.setChartWidthAttribs(e);Fisma.Chart.chartsOnDOM[e.uniqueid]=jQuery.extend(true,{},e);var a=Fisma.Chart.CHART_CREATE_FAILURE;if(!Fisma.Chart.chartIsEmpty(e)){switch(e.chartType){case"stackedbar":e.varyBarColor=false;if(typeof e.showlegend==="undefined"){e.showlegend=true}a=Fisma.Chart.createChartStackedBar(e);break;case"bar":if(typeof e.chartData[0]==="object"){e.varyBarColor=false;e.showlegend=true}else{e.chartData=[e.chartData];e.links=[e.links];e.varyBarColor=true;e.showlegend=false}e.stackSeries=false;a=Fisma.Chart.createChartStackedBar(e);break;case"line":a=Fisma.Chart.createChartStackedLine(e);break;case"stackedline":a=Fisma.Chart.createChartStackedLine(e);break;case"pie":e.links=[e.links];a=Fisma.Chart.createChartPie(e);break;default:throw"createJQChart Error - chartType is invalid ("+e.chartType+")"}}Fisma.Chart.removeOverlappingPointLabels(e);Fisma.Chart.applyChartBackground(e);Fisma.Chart.applyChartWidgets(e);Fisma.Chart.createChartThreatLegend(e);Fisma.Chart.applyChartBorders(e);Fisma.Chart.globalSettingRefreshUi(e);Fisma.Chart.showMsgOnEmptyChart(e);Fisma.Chart.getTableFromChartData(e);Fisma.Chart.setTitle(e);Fisma.Chart.placeCanvasesInDivs(e);return a},mergeExtrnIntoParamObjectByInheritance:function(c,a){var b={};if(a.results[0].inheritCtl){if(a.results[0].inheritCtl==="minimal"){b=a.results[0];b.width=c.width;b.height=c.height;b.uniqueid=c.uniqueid;b.externalSource=c.externalSource;b.oldExternalSource=c.oldExternalSource;b.widgets=c.widgets}else{if(a.results[0].inheritCtl==="none"){b=a.results[0]}else{throw"Error - Unknown chart inheritance mode"}}}else{b=jQuery.extend(true,c,a.results[0],true)}return b},createChartPie:function(f){var b=0;var d=[];usedLabelsPie=f.chartDataText;for(b=0;b<f.chartData.length;b++){f.chartDataText[b]+=" ("+f.chartData[b]+")";d[d.length]=[f.chartDataText[b],f.chartData[b]]}var a={seriesColors:f.colors,grid:{drawBorder:false,drawGridlines:false,shadow:false},axes:{xaxis:{tickOptions:{angle:f.DataTextAngle,fontSize:"10pt",formatString:"%.0f"}},yaxis:{tickOptions:{formatString:"%.0f"}}},seriesDefaults:{renderer:$.jqplot.PieRenderer,rendererOptions:{sliceMargin:0,showDataLabels:true,shadowAlpha:0.15,shadowOffset:0,lineLabels:true,lineLabelsLineColor:"#777",diameter:f.height*0.55,dataLabelFormatString:"%d%"}},legend:{location:"s",show:true,rendererOptions:{numberRows:2}},highlighter:{show:false}};a.seriesDefaults.renderer.prototype.startAngle=0;$("[id="+f.uniqueid+"]").css("height",f.height);a=jQuery.extend(true,a,f);a.title=null;plot1=$.jqplot(f.uniqueid,[d],a);var c=new Function("ev","seriesIndex","pointIndex","data","var thisChartParamObj = "+YAHOO.lang.JSON.stringify(f)+"; Fisma.Chart.chartClickEvent(ev, seriesIndex, pointIndex, data, thisChartParamObj);");$("#"+f.uniqueid).bind("jqplotDataHighlight",function(j,h,i,k){Fisma.Chart.chartHighlightEvent(f,j,h,i,k)});$("#"+f.uniqueid).bind("jqplotDataUnhighlight",function(j,h,i,k){Fisma.Chart.hideAllChartTooltips()});var g=YAHOO.util.Dom.get(f.uniqueid);var e=$(g).find("canvas").filter(function(){return $(this)[0].className==="jqplot-event-canvas"});e[0].onmousemove=function(h){Fisma.Chart.chartMouseMovePieEvent(f,h,e[0])};e[0].onmouseout=function(h){Fisma.Chart.hideAllChartTooltips()};$("#"+f.uniqueid).bind("jqplotDataClick",c);return Fisma.Chart.CHART_CREATE_SUCCESS},createChartStackedBar:function(l){var j=0;var g=0;var d=0;var h=0;var c=0;for(j=0;j<l.chartDataText.length;j++){d=0;for(g=0;g<l.chartData.length;g++){d+=l.chartData[g][j]}if(d>h){h=d}if(l.concatXLabel===true){l.chartDataText[j]+=" ("+d+")"}}var b=[];if(l.chartLayerText){for(j=0;j<l.chartLayerText.length;j++){b[j]={label:l.chartLayerText[j]}}}c=Math.ceil(h/5)*5;yAxisTicks=[];yAxisTicks[0]=0;yAxisTicks[1]=(c/5);yAxisTicks[2]=(c/5)*2;yAxisTicks[3]=(c/5)*3;yAxisTicks[4]=(c/5)*4;yAxisTicks[5]=(c/5)*5;$.jqplot.config.enablePlugins=true;var a={seriesColors:l.colors,stackSeries:true,series:b,seriesDefaults:{renderer:$.jqplot.BarRenderer,rendererOptions:{barWidth:35,showDataLabels:true,varyBarColor:l.varyBarColor,shadowAlpha:0.15,shadowOffset:0},pointLabels:{show:false,location:"s",hideZeros:true}},axesDefaults:{tickRenderer:$.jqplot.CanvasAxisTickRenderer,borderWidth:0,labelOptions:{enableFontSupport:true,fontFamily:"arial, helvetica, clean, sans-serif",fontSize:"12pt",textColor:"#000000"}},axes:{xaxis:{label:l.AxisLabelX,labelRenderer:$.jqplot.CanvasAxisLabelRenderer,renderer:$.jqplot.CategoryAxisRenderer,ticks:l.chartDataText,tickOptions:{angle:l.DataTextAngle,fontFamily:"arial, helvetica, clean, sans-serif",fontSize:"10pt",textColor:"#000000"}},yaxis:{label:l.AxisLabelY,labelRenderer:$.jqplot.CanvasAxisLabelRenderer,min:0,max:c,autoscale:true,ticks:yAxisTicks,tickOptions:{formatString:"%.0f",fontFamily:"arial, helvetica, clean, sans-serif",fontSize:"10pt",textColor:"#000000"}}},highlighter:{show:true,showMarker:false,showTooltip:true,tooltipAxes:"xy",yvalues:1,tooltipLocation:"e",formatString:"-"},grid:{gridLineWidth:0,shadow:false,borderWidth:1,gridLineColor:"#FFFFFF",background:"transparent",drawGridLines:l.drawGridLines,show:l.drawGridLines},legend:{show:l.showlegend,rendererOptions:{numberRows:2},location:"nw"}};if(Fisma.Chart.isIE){a.grid.background="#FFFFFF"}$("[id="+l.uniqueid+"]").css("height",l.height);a=jQuery.extend(true,a,l);a=Fisma.Chart.alterChartByGlobals(a);a.title=null;Fisma.Chart.hookPostDrawSeriesHooks();plot1=$.jqplot(l.uniqueid,l.chartData,a);var k=new Function("ev","seriesIndex","pointIndex","data","var thisChartParamObj = "+YAHOO.lang.JSON.stringify(l)+"; Fisma.Chart.chartClickEvent(ev, seriesIndex, pointIndex, data, thisChartParamObj);");$("#"+l.uniqueid).bind("jqplotDataClick",k);$("#"+l.uniqueid).bind("jqplotDataHighlight",function(o,m,n,p){Fisma.Chart.chartHighlightEvent(l,o,m,n,p)});var f=YAHOO.util.Dom.get(l.uniqueid);var i=$(f).find("canvas").filter(function(){return $(this)[0].className==="jqplot-event-canvas"});i[0].onmouseout=function(m){Fisma.Chart.hideAllChartTooltips()};var e=Fisma.Chart.getElementsByClassWithinObj("jqplot-xaxis-tick","canvas",l.uniqueid);for(j=0;j<e.length;j++){e[j].columnNumber=j;e[j].onmouseover=function(n){var m={left:this.parentNode.offsetLeft+"px",bottom:(this.parentNode.parentNode.offsetHeight+10)+"px",top:""};Fisma.Chart.chartHighlightEvent(l,n,0,this.columnNumber,null,m)};e[j].onmouseout=function(m){Fisma.Chart.hideAllChartTooltips()};e[j].style.zIndex=1}Fisma.Chart.removeDecFromPointLabels(l);return Fisma.Chart.CHART_CREATE_SUCCESS},getTooltipObjOfChart:function(a){return Fisma.Chart.getElementsByClassWithinObj("jqplot-highlighter-tooltip","div",a.uniqueid)[0]},getElementsByClassWithinObj:function(c,a,b){if(b===null||b===""){b=document.body}if(typeof b!=="object"){b=document.getElementById(b)}var d=$(b).find(a).filter(function(){return $(this)[0].className.indexOf(c)!==-1});return d},createChartStackedLine:function(c){var a=0;var d=0;var b=0;for(a=0;a<c.chartDataText.length;a++){b=0;for(d=0;d<["chartData"].length;d++){b+=["chartData"][d][a]}c.chartDataText[a]+=" ("+b+")"}plot1=$.jqplot(c.uniqueid,c.chartData,{seriesColors:["#F4FA58","#FAAC58","#FA5858"],series:[{label:"Open Findings",lineWidth:4,markerOptions:{style:"square"}},{label:"Closed Findings",lineWidth:4,markerOptions:{style:"square"}},{lineWidth:4,markerOptions:{style:"square"}}],seriesDefaults:{fill:false,showMarker:true,showLine:true},axes:{xaxis:{renderer:$.jqplot.CategoryAxisRenderer,ticks:c.chartDataText},yaxis:{min:0}},highlighter:{show:false},legend:{show:true,rendererOptions:{numberRows:2},location:"nw"}});return Fisma.Chart.CHART_CREATE_SUCCESS},hookPostDrawSeriesHooks:function(){if(Fisma.Chart.hasHookedPostDrawSeries!==false){return}Fisma.Chart.hasHookedPostDrawSeries=true;$.jqplot.postDrawSeriesHooks.push(function(c){var e=Fisma.Chart.getGlobalSetting("usePatterns");if(e==="false"){return}if(this._barPoints===undefined){return}if(this.canvas._elem.context.parentNode.id!==undefined){var g=this.canvas._elem.context.parentNode.id;chartParamsObj=Fisma.Chart.chartsOnDOM[g]}if(Fisma.Chart.chartsOnDOM[g].patternCounter===undefined){Fisma.Chart.chartsOnDOM[g].patternCounter=0}var b=Fisma.Chart.chartsOnDOM[g].patternCounter;var d=Fisma.Chart.patternURLs[b];Fisma.Chart.chartsOnDOM[g].patternCounter++;for(var f=0;f<this._barPoints.length;f++){var a=new Image();a.barRect={x:this._barPoints[f][0][0],y:this._barPoints[f][0][1],w:this._barPoints[f][2][0]-this._barPoints[f][0][0],h:this._barPoints[f][1][1]-this._barPoints[f][3][1]};a.onload=function(){var h=c.createPattern(a,"repeat");c.fillStyle=h;c.fillRect(this.barRect.x,this.barRect.y,this.barRect.w,this.barRect.h);c.restore()};a.src=d}return});return},createChartThreatLegend:function(m){if(m.showThreatLegend&&!Fisma.Chart.chartIsEmpty(m)){if(m.showThreatLegend===true){var e="100%";if(m.threatLegendWidth){e=m.threatLegendWidth}var k;var g=document.createElement("table");g.style.fontSize="12px";g.style.color="#000000";g.width=e;var d=document.createElement("tbody");var l=document.createElement("tr");k=document.createElement("td");k.style.textAlign="center";k.style.fontWeight="bold";k.width="40%";var a=document.createTextNode("");k.appendChild(a);l.appendChild(k);var b;var c;var j;for(var f in m.chartLayerText){k=document.createElement("td");k.width="20%";c=Fisma.Chart.getGlobalSetting("usePatterns");if(c==="true"){b=Fisma.Chart.patternURLs[f]}else{b=m.colors[f];b=b.replace("#","")}j=m.chartLayerText[f];k.appendChild(Fisma.Chart.createThreatLegendSingleColor(b,j));l.appendChild(k)}d.appendChild(l);g.appendChild(d);var i=m.uniqueid;var h=document.getElementById(i+"toplegend");h.appendChild(g)}}},createThreatLegendSingleColor:function(c,d){var g=document.createElement("table");var f=document.createElement("tbody");var b=document.createElement("tr");var e;e=document.createElement("td");if(c.indexOf("/")===-1){e.style.backgroundColor="#"+c}else{e.style.backgroundImage="url("+c+")"}e.width="15px";b.appendChild(e);e=document.createElement("td");e.width="3px";b.appendChild(e);e=document.createElement("td");e.style.fontSize="12px";var a=document.createTextNode("   "+d);e.appendChild(a);b.appendChild(e);f.appendChild(b);g.appendChild(f);return g},chartHighlightEvent:function(k,g,d,h,e,f){Fisma.Chart.hideAllChartTooltips();var a=Fisma.Chart.getTooltipObjOfChart(k);var c;if(typeof k.tooltip[0]!=="object"){customTooltip=k.tooltip[h]}else{customTooltip=k.tooltip[d][h]}if(typeof k.chartData[d]!=="object"){c=k.chartData[h]}else{c=k.chartData[d][h]}var b='<span class="chartToolTipText">';if(customTooltip!==""&&customTooltip!==undefined){b+=customTooltip}else{b+=c}b+="</span>";b=b.replace("#percent#",Fisma.Chart.getPercentage(k,d,h));b=b.replace("#columnName#",k.chartDataText[h]);if(e!==undefined&&e!==null){b=b.replace("#count#",e[1])}if(k.chartLayerText){b=b.replace("#layerName#",k.chartLayerText[d])}if(b.indexOf("#columnReport#")!==-1){b=b.replace("#columnReport#",Fisma.Chart.getColumnReport(k,d,h))}a.innerHTML=b;a.style.display="block";a.style.bottom="";a.style.right="";if(navigator.appVersion.indexOf("MSIE 7")!=-1){a.style.width="80px"}if(f!==undefined&&f!==null){for(var i in f){a.style[i]=f[i]}}if(k.chartType==="pie"){a.style.display="none";var j=document.getElementById(k.uniqueid+"pieTooltip");j.style.display="block";j.innerHTML=b;if(navigator.appVersion.indexOf("MSIE 7")!=-1){j.style.width="200px"}}},getColumnReport:function(f,c,d){var b="";var e=0;for(var a=0;a<f.chartLayerText.length;a++){b+=f.chartLayerText[a]+": "+f.chartData[a][d]+"<br/>";e+=f.chartData[a][d]}b+="Total: "+e;return b},getPercentage:function(f,b,e){if(typeof f.chartData[0]==="object"){return 0}else{var d=0;for(var c=0;c<f.chartData.length;c++){d+=f.chartData[c]}var a=f.chartData[e]/d;return Math.round(a*100)}},hideAllChartTooltips:function(){var b=$(document.body).find("div").filter(function(){return $(this)[0].className.indexOf("jqplot-highlighter-tooltip")!==-1});for(var a=0;a<b.length;a++){b[a].style.display="none"}},chartMouseMovePieEvent:function(c,f,b){var d=document.getElementById(c.uniqueid+"pieTooltip");var a;var g;if(window.event!==undefined){a=window.event.offsetX;g=window.event.offsetY;g+=65}else{if(f.offsetX!==undefined){a=f.offsetX;g=f.offsetY;g+=45}else{if(f.layerX!==undefined){a=f.layerX;g=f.layerY;g+=45}else{a=0;g=0}}}d.style.left=(a+b.offsetLeft)+"px";d.style.top=g+"px"},chartClickEvent:function(d,a,c,e,b){var g=false;if(b.links){if(typeof b.links==="string"){g=b.links}else{if(b.links[a]){if(typeof b.links[a]==="object"){g=b.links[a][c]}else{g=b.links[a]}}}}if(g===""){return}if(g!==false){g=String(g).replace("#ColumnLabel#",encodeURIComponent(b.chartDataText[c]))}g=escape(g);g=g.replace("%3F","?");g=g.replace("%3D","=");if(b.linksdebug===true){var f="You clicked on layer "+a+", in column "+c+", which has the data of "+e[1]+"\n";f+="The link information for this element should be stored as a string in chartParamData['links'], or as a string in chartParamData['links']["+a+"]["+c+"]\n";if(g!==false){f+="The link with this element is "+g}Fisma.Util.showAlertDialog(f)}else{if(g!==false&&g!=="false"&&String(g)!=="null"){document.location=g}}},forceIntegerArray:function(b){var a=0;for(a=0;a<b.length;a++){if(typeof b[a]==="object"){b[a]=Fisma.Chart.forceIntegerArray(b[a])}else{b[a]=parseInt(b[a],10)}}return b},applyChartBorders:function(g){var a=0;if(typeof g.borders==="undefined"){if(g.chartType==="bar"||g.chartType==="stackedbar"){g.borders="BL"}else{return}}var i=document.getElementById(g.uniqueid);var d=i.childNodes;for(a=d.length-1;a>0;a--){if(typeof d[a].nodeName!=="undefined"){if(String(d[a].nodeName).toLowerCase()==="canvas"&&d[a].className==="jqplot-series-shadowCanvas"){var f=d[a];var c=f.getContext("2d");var e=d[a].height;var b=d[a].width;c.strokeStyle="#777777";c.lineWidth=3;c.beginPath();if(g.borders.indexOf("L")!==-1){c.moveTo(0,0);c.lineTo(0,e);c.stroke()}if(g.borders.indexOf("B")!==-1){c.moveTo(0,e);c.lineTo(b,e);c.stroke()}if(g.borders.indexOf("R")!==-1){c.moveTo(b,0);c.lineTo(b,e);c.stroke()}if(g.borders.indexOf("T")!==-1){c.moveTo(0,0);c.lineTo(b,0);c.stroke()}return}}}},applyChartBackground:function(e){var g=document.getElementById(e.uniqueid);if(e.nobackground){if(e.nobackground===true){return}}if(e.background){if(e.background.nobackground){if(e.background.nobackground===true){return}}}var b="/images/logoShark.png";if(e.background){if(e.background.URL){b=e.background.URL}}var d='<img height="100%" src="'+b+'" style="opacity:0.15;filter:alpha(opacity=15);opacity:0.15" />';if(e.background){if(e.background.overrideHTML){b=e.background.overrideHTML}}var a;var h;if(e.chartType==="pie"){a=g.childNodes[3];h=g.childNodes[4]}else{a=g.childNodes[6];h=g.childNodes[5]}var f=a.style;injectedBackgroundImg=document.createElement("span");injectedBackgroundImg.setAttribute("align","center");injectedBackgroundImg.setAttribute("style","position: absolute; left: "+f.left+"; top: "+f.top+"; width: "+a.width+"px; height: "+a.height+"px;");var c=g.insertBefore(injectedBackgroundImg,h);c.innerHTML=d},applyChartWidgets:function(d){var a=0;var f=0;var e=document.getElementById(d.uniqueid+"WidgetSpace");if(typeof d.widgets==="undefined"){e.innerHTML="<br/><i>There are no parameters for this chart.</i><br/><br/>";return}else{if(d.widgets.length===0){e.innerHTML="<br/><i>There are no parameters for this chart.</i><br/><br/>";return}}if(d.widgets){var b="";for(a=0;a<d.widgets.length;a++){var c=d.widgets[a];if(!c.uniqueid){c.uniqueid=d.uniqueid+"_widget"+a;d.widgets[a].uniqueid=c.uniqueid}b+="<tr><td nowrap align=left>"+c.label+' </td><td><td nowrap width="10"></td><td width="99%" align=left>';switch(c.type){case"combo":b+='<select id="'+c.uniqueid+'" onChange="Fisma.Chart.widgetEvent('+YAHOO.lang.JSON.stringify(d).replace(/"/g,"'")+');">';for(f=0;f<c.options.length;f++){b+='<option value="'+c.options[f]+'">'+c.options[f]+"</option><br/>"}b+="</select>";break;case"text":b+='<input onKeyDown="if(event.keyCode==13){Fisma.Chart.widgetEvent('+YAHOO.lang.JSON.stringify(d).replace(/"/g,"'")+');};" type="textbox" id="'+c.uniqueid+'" />';break;default:throw"Error - Widget "+a+"'s type ("+c.type+") is not a known widget type"}b+="</td></tr>"}e.innerHTML="<table>"+b+"</table>"}Fisma.Chart.applyChartWidgetSettings(d)},applyChartWidgetSettings:function(e){var a=0;if(e.widgets){for(a=0;a<e.widgets.length;a++){var c=e.widgets[a];var d=document.getElementById(c.uniqueid);if(c.forcevalue){d.value=c.forcevalue;d.text=c.forcevalue}else{var b=YAHOO.util.Cookie.get(e.uniqueid+"_"+c.uniqueid);if(b!==null){b=b.replace(/%20/g," ");d.value=b;d.text=b}else{if(c.defaultvalue){d.value=c.defaultvalue;d.text=c.defaultvalue}}}}}},buildExternalSourceParams:function(g){var c=0;var b="";g.externalSourceParams="";if(g.widgets){for(c=0;c<g.widgets.length;c++){var f=g.widgets[c];var a=f.uniqueid;var e=document.getElementById(a);if(e){b=e.value}else{var d=YAHOO.util.Cookie.get(g.uniqueid+"_"+f.uniqueid);if(d!==null){b=d}else{if(f.defaultvalue){b=f.defaultvalue}}}g.externalSourceParams+="/"+a+"/"+b}}return g},widgetEvent:function(d){var c=0;if(d.widgets){for(c=0;c<d.widgets.length;c++){var b=d.widgets[c].uniqueid;var a=document.getElementById(b).value;YAHOO.util.Cookie.set(d.uniqueid+"_"+b,a,{path:"/"})}}d=Fisma.Chart.buildExternalSourceParams(d);d.externalSource=d.oldExternalSource;d.oldExternalSource=undefined;d.chartData=undefined;d.chartDataText=undefined;document.getElementById(d.uniqueid+"holder").finnishFadeCallback=new Function("Fisma.Chart.makeElementVisible('"+d.uniqueid+"loader'); Fisma.Chart.createJQChart("+YAHOO.lang.JSON.stringify(d)+"); Fisma.Chart.finnishFadeCallback = '';");Fisma.Chart.fadeOut(d.uniqueid+"holder",300)},makeElementVisible:function(a){var b=document.getElementById(a);b.style.opacity="1";b.style.filter="alpha(opacity = '100')"},makeElementInvisible:function(a){var b=document.getElementById(a);b.style.opacity="0";b.style.filter="alpha(opacity = '0')"},fadeIn:function(a,d){var c=document.getElementById(a);if(c===null){return}var b=("fadingEnabled");if(b==="false"){Fisma.Chart.makeElementVisible(a);if(c.finnishFadeCallback){c.finnishFadeCallback();c.finnishFadeCallback=undefined}return}if(typeof c.isFadingNow!=="undefined"){if(c.isFadingNow===true){return}}c.isFadingNow=true;c.FadeState=null;c.FadeTimeLeft=undefined;Fisma.Chart.makeElementInvisible(a);c.style.opacity="0";c.style.filter="alpha(opacity = '0')";Fisma.Chart.fade(a,d)},fadeOut:function(a,d){var c=document.getElementById(a);if(c===null){return}var b=Fisma.Chart.getGlobalSetting("fadingEnabled");if(b==="false"){Fisma.Chart.makeElementInvisible(a);if(c.finnishFadeCallback){c.finnishFadeCallback();c.finnishFadeCallback=undefined}return}if(typeof c.isFadingNow!=="undefined"){if(c.isFadingNow===true){return}}c.isFadingNow=true;c.FadeState=null;c.FadeTimeLeft=undefined;Fisma.Chart.makeElementVisible(a);c.style.opacity="1";c.style.filter="alpha(opacity = '100')";Fisma.Chart.fade(a,d)},fade:function(a,c){var b=document.getElementById(a);if(b===null){return}if(b.FadeState===null){if(b.style.opacity===null||b.style.opacity===""||b.style.opacity==="1"){b.FadeState=2}else{b.FadeState=-2}}if(b.FadeState===1||b.FadeState===-1){b.FadeState=b.FadeState===1?-1:1;b.FadeTimeLeft=c-b.FadeTimeLeft}else{b.FadeState=b.FadeState===2?-1:1;b.FadeTimeLeft=c;setTimeout("Fisma.Chart.animateFade("+new Date().getTime()+",'"+a+"',"+c+")",33)}},animateFade:function(d,a,f){var b=new Date().getTime();var g=b-d;var c=document.getElementById(a);if(c.FadeTimeLeft<=g){if(c.FadeState===1){c.style.filter="alpha(opacity = 100)";c.style.opacity="1"}else{c.style.filter="alpha(opacity = 0)";c.style.opacity="0"}c.isFadingNow=false;c.FadeState=c.FadeState===1?2:-2;if(c.finnishFadeCallback){c.finnishFadeCallback();c.finnishFadeCallback=""}return}c.FadeTimeLeft-=g;var e=c.FadeTimeLeft/f;if(c.FadeState===1){e=1-e}c.style.opacity=e;c.style.filter='alpha(opacity = "'+(e*100)+'")';setTimeout("Fisma.Chart.animateFade("+b+",'"+a+"',"+f+")",33)},setChartWidthAttribs:function(d){var b=false;var a;if(d.chartData){if(d.chartType==="bar"||d.chartType==="stackedbar"){var c;if(d.chartType==="stackedbar"){if(typeof d.chartData[0]==="undefined"){return}else{c=d.chartData[0].length}}else{if(d.chartType==="bar"){c=d.chartData.length}}a=(c*10)+(c*35)+40;if(d.width<a){b=true}}}if(typeof d.autoWidth!=="undefined"){if(d.autoWidth===true){b=true}}if(b===true){document.getElementById(d.uniqueid+"loader").style.width="100%";document.getElementById(d.uniqueid+"holder").style.width="100%";document.getElementById(d.uniqueid+"holder").style.overflow="auto";document.getElementById(d.uniqueid).style.width=a+"px";document.getElementById(d.uniqueid+"toplegend").style.width=a+"px";if(d.align==="center"){document.getElementById(d.uniqueid).style.marginLeft="auto";document.getElementById(d.uniqueid).style.marginRight="auto";document.getElementById(d.uniqueid+"toplegend").style.marginLeft="auto";document.getElementById(d.uniqueid+"toplegend").style.marginRight="auto"}}else{document.getElementById(d.uniqueid+"loader").style.width="100%";document.getElementById(d.uniqueid+"holder").style.width=d.width+"px";document.getElementById(d.uniqueid+"holder").style.overflow="";document.getElementById(d.uniqueid).style.width=d.width+"px";document.getElementById(d.uniqueid+"toplegend").width=d.width+"px"}},getTableFromChartData:function(b){if(Fisma.Chart.chartIsEmpty(b)){return}var a=document.getElementById(b.uniqueid+"table");a.innerHTML="";if(Fisma.Chart.getGlobalSetting("showDataTable")==="true"){if(b.chartType==="pie"){Fisma.Chart.getTableFromChartPieChart(b,a)}else{Fisma.Chart.getTableFromBarChart(b,a)}a.style.display="";document.getElementById(b.uniqueid).innerHTML="";document.getElementById(b.uniqueid).style.width=0;document.getElementById(b.uniqueid).style.height=0;document.getElementById(b.uniqueid+"toplegend").style.display="none"}else{a.style.display="none"}},getTableFromChartPieChart:function(e,d){var g=document.createElement("table");var f=document.createElement("tbody");var b=0;var a;var c;var h;h=document.createElement("tr");for(b=0;b<e.chartDataText.length;b++){a=document.createElement("th");c=document.createTextNode(e.chartDataText[b]);a.setAttribute("style","font-style: bold;");a.appendChild(c);h.appendChild(a)}f.appendChild(h);h=document.createElement("tr");for(b=0;b<e.chartData.length;b++){a=document.createElement("td");c=document.createTextNode(e.chartData[b]);a.appendChild(c);h.appendChild(a)}f.appendChild(h);g.appendChild(f);g.setAttribute("border","1");g.setAttribute("width","100%");d.appendChild(g)},getTableFromBarChart:function(i,a){var f=0;var d=0;var g;var j;var b=document.createElement("table");var c=document.createElement("tbody");var h=document.createElement("tr");if(typeof i.chartLayerText!=="undefined"){g=document.createElement("td");j=document.createTextNode(" ");g.appendChild(j);h.appendChild(g)}for(f=0;f<i.chartDataText.length;f++){g=document.createElement("th");j=document.createTextNode(i.chartDataText[f]);g.setAttribute("style","font-style: bold;");g.appendChild(j);h.appendChild(g)}c.appendChild(h);for(f=0;f<i.chartData.length;f++){var e=i.chartData[f];h=document.createElement("tr");if(typeof i.chartLayerText!=="undefined"){g=document.createElement("th");j=document.createTextNode(i.chartLayerText[f]);g.setAttribute("style","font-style: bold;");g.appendChild(j);h.appendChild(g)}if(typeof(e)==="object"){for(d=0;d<e.length;d++){g=document.createElement("td");j=document.createTextNode(e[d]);g.setAttribute("style","font-style: bold;");g.appendChild(j);h.appendChild(g)}}else{g=document.createElement("td");j=document.createTextNode(e);g.appendChild(j);h.appendChild(g)}c.appendChild(h)}b.appendChild(c);b.setAttribute("border","1");b.setAttribute("width","100%");a.appendChild(b)},removeDecFromPointLabels:function(g){var f="";var b=document.getElementById(g.uniqueid);var a=0;for(a=0;a<b.childNodes.length;a++){var e=b.childNodes[a];if(typeof e.classList==="undefined"){e.classList=String(e.className).split(" ")}if(e.classList){if(e.classList[0]==="jqplot-point-label"){thisLabelValue=parseInt(e.innerHTML,10);e.innerHTML=thisLabelValue;e.value=thisLabelValue;if(parseInt(e.innerHTML,10)===0||isNaN(thisLabelValue)){e.innerHTML=""}if(Fisma.Chart.getGlobalSetting("pointLabelsOutline")==="true"){f="text-shadow: ";f+="#FFFFFF 0px -1px 0px, ";f+="#FFFFFF 0px 1px 0px, ";f+="#FFFFFF 1px 0px 0px, ";f+="#FFFFFF -1px 1px 0px, ";f+="#FFFFFF -1px -1px 0px, ";f+="#FFFFFF 1px 1px 0px; ";e.innerHTML='<span style="'+f+g.pointLabelStyle+'">'+e.innerHTML+"</span>";e.style.textShadow="text-shadow: #FFFFFF 0px -1px 0px, #FFFFFF 0px 1px 0px, #FFFFFF 1px 0px 0px, #FFFFFF -1px 1px 0px, #FFFFFF -1px -1px 0px, #FFFFFF 1px 1px 0px;"}else{e.innerHTML='<span style="'+g.pointLabelStyle+'">'+e.innerHTML+"</span>"}var d=parseInt(String(e.style.left).replace("px",""),10);var c=parseInt(String(e.style.top).replace("px",""),10);d+=g.pointLabelAdjustX;c+=g.pointLabelAdjustY;if(thisLabelValue>=100){d-=2}if(thisLabelValue>=1000){d-=3}e.style.left=d+"px";e.style.top=c+"px";e.style.color="black"}}}},removeOverlappingPointLabels:function(l){if(l.chartType!=="stackedbar"&&l.chartType!=="stackedline"){return}var m=document.getElementById(l.uniqueid);var b=[];var c;var e;var f;var i=0;var h=0;var g=0;for(i=0;i<m.childNodes.length;i++){var k=m.childNodes[i];if(typeof k.classList==="undefined"){k.classList=String(k.className).split(" ")}if(k.classList[0]==="jqplot-point-label"){var j=false;if(typeof k.isRemoved!=="undefined"){j=k.isRemoved}if(j===false){c=parseInt(String(k.style.left).replace("px",""),10);e=parseInt(String(k.style.top).replace("px",""),10);f=k.value;var a={left:c,top:e,value:f,obj:k};b.push(a)}}}$.each(b,function(n,d){$.each(b,function(r,q){var p=(d.left-q.left);p=p*p;var o=(d.top-q.top);o=o*o;var s=Math.sqrt(p+o);if(s<17&&s!==0&&!isNaN(q.value)&&!isNaN(d.value)){if(q.value<d.value){q.obj.innerHTML="";q.obj.isRemoved=true}else{d.obj.innerHTML="";d.obj.isRemoved=true}Fisma.Chart.removeOverlappingPointLabels(l);return}})})},hideButtonClick:function(a,b,c){Fisma.Chart.setChartSettingsVisibility(b,false)},setChartSettingsVisibility:function(d,c){var a=d+"WidgetSpaceHolder";var b=document.getElementById(a);if(c==="toggle"){if(b.style.display==="none"){c=true}else{c=false}}if(c===true){b.style.display=""}else{b.style.display="none"}},globalSettingUpdate:function(f,c){var b=document.getElementById(c+"GlobSettings");var e=b.childNodes;var a=0;for(a=0;a<e.length;a++){var d=e[a];if(d.nodeName==="INPUT"){if(d.type==="checkbox"){Fisma.Chart.setGlobalSetting(d.id,d.checked)}else{Fisma.Chart.setGlobalSetting(d.id,d.value)}}}Fisma.Chart.redrawAllCharts()},globalSettingRefreshUi:function(e){var b=document.getElementById(e.uniqueid+"GlobSettings");var d=b.childNodes;var a=0;for(a=0;a<d.length;a++){var c=d[a];if(c.nodeName==="INPUT"){if(c.type==="checkbox"){c.checked=(Fisma.Chart.getGlobalSetting(c.id)==="true")?true:false}else{c.value=Fisma.Chart.getGlobalSetting(c.id);c.text=c.value}}}},showSetingMode:function(c){var b=0;var a;var d;if(c===true){d=document.getElementsByName("chartSettingsBasic");a=document.getElementsByName("chartSettingsGlobal")}else{a=document.getElementsByName("chartSettingsBasic");d=document.getElementsByName("chartSettingsGlobal")}for(b=0;b<a.length;b++){a[b].style.display="none"}for(b=0;b<a.length;b++){d[b].style.display=""}},getGlobalSetting:function(b){var a=YAHOO.util.Cookie.get("chartGlobSetting_"+b);if(a!==null){return a}else{if(typeof Fisma.Chart.globalSettingsDefaults[b]==="undefined"){throw"You have referenced a global setting ("+b+"), but have not defined a default value for it! Please defined a def-value in the object called globalSettingsDefaults that is located within the global scope of Chart.js"}else{return String(Fisma.Chart.globalSettingsDefaults[b])}}},setGlobalSetting:function(a,b){YAHOO.util.Cookie.set("chartGlobSetting_"+a,b,{path:"/"})},alterChartByGlobals:function(a){if(Fisma.Chart.getGlobalSetting("barShadows")==="true"){a.seriesDefaults.rendererOptions.shadowDepth=3;a.seriesDefaults.rendererOptions.shadowOffset=3}if(Fisma.Chart.getGlobalSetting("barShadowDepth")!=="no-setting"&&Fisma.Chart.getGlobalSetting("barShadows")==="true"){a.seriesDefaults.rendererOptions.shadowDepth=Fisma.Chart.getGlobalSetting("barShadowDepth");a.seriesDefaults.rendererOptions.shadowOffset=Fisma.Chart.getGlobalSetting("barShadowDepth")}if(Fisma.Chart.getGlobalSetting("gridLines")==="true"){a.grid.gridLineWidth=1;a.grid.borderWidth=0;a.grid.gridLineColor=undefined;a.grid.drawGridLines=true;a.grid.show=true}if(Fisma.Chart.getGlobalSetting("dropShadows")!=="false"){a.grid.shadow=true}if(Fisma.Chart.getGlobalSetting("pointLabels")==="true"){a.seriesDefaults.pointLabels.show=true}return a},redrawAllCharts:function(c){var a;var b;for(b in Fisma.Chart.chartsOnDOM){a=Fisma.Chart.chartsOnDOM[b];Fisma.Chart.showChartLoadingMsg(a)}if(Fisma.Chart.isIE===true){if(c!==true||c===null){setTimeout("Fisma.Chart.redrawAllCharts(true);",300);return}}for(b in Fisma.Chart.chartsOnDOM){a=Fisma.Chart.chartsOnDOM[b];Fisma.Chart.createJQChart(a);Fisma.Chart.globalSettingRefreshUi(a)}},showChartLoadingMsg:function(d){document.getElementById(d.uniqueid+"toplegend").innerHTML="";Fisma.Chart.makeElementVisible(d.uniqueid+"loader");var b=document.getElementById(d.uniqueid);var a=document.createTextNode("\n\n\n\nLoading chart data...");var c=document.createElement("p");c.align="center";c.appendChild(a);b.innerHTML="";b.appendChild(document.createElement("br"));b.appendChild(document.createElement("br"));b.appendChild(document.createElement("br"));b.appendChild(document.createElement("br"));b.appendChild(c)},setTitle:function(a){},showMsgOnEmptyChart:function(d){if(Fisma.Chart.chartIsEmpty(d)){var e=document.getElementById(d.uniqueid);var f=e.childNodes[1];var b=document.createElement("div");b.height="100%";b.style.align="center";b.style.position="absolute";b.style.width=d.width+"px";b.style.height="100%";b.style.textAlign="center";b.style.verticalAlign="middle";b.appendChild(document.createTextNode("No data to plot. "));var a=document.createElement("a");a.href="JavaScript: Fisma.Chart.setChartSettingsVisibility('"+d.uniqueid+"', 'toggle');";a.appendChild(document.createTextNode("Change chart parameters?"));b.appendChild(a);e.appendChild(b);var c=document.getElementById(d.uniqueid+"table");c.style.display="none"}},chartIsEmpty:function(c){var b=true;var a=0;var d=0;for(a in c.chartData){if(typeof c.chartData[a]==="object"){for(d in c.chartData[a]){if(parseInt(c.chartData[a][d],10)>0){b=false}}}else{if(parseInt(c.chartData[a],10)>0){b=false}}}return b},placeCanvasesInDivs:function(b){var c=YAHOO.util.Dom.get(b.uniqueid);var a=$(c).find("canvas").filter(function(){return $(this).css("position")=="absolute"});a.wrap(function(){var e;var d=$(this);var e;if(d.context.className=="jqplot-yaxis-tick"){e=$("<div />").css({position:"absolute",top:d.css("top"),right:d.css("right")});d.css({top:0,right:0});if(Fisma.Chart.isIE===false){e.className="chart-yaxis-tick"}else{e.className="chart-yaxis-tick-InIE"}}else{if(d.context.className=="jqplot-xaxis-label"){e=$("<div />").css({position:"absolute",bottom:"0px"})}else{e=$("<div />").css({position:"absolute",top:d.css("top"),left:d.css("left")});d.css({top:0,left:0})}}return e});return this}};