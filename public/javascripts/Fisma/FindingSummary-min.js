Fisma.FindingSummary=function(){return{treeRoot:null,filterType:null,filterSource:null,defaultDisplayLevel:2,render:function(h,j,t){if(t){this.treeRoot=j}var p=document.getElementById(h);for(var f in j){var r;var l=j[f];var a=p.insertRow(p.rows.length);a.id=l.nickname+"_ontime";var e=p.insertRow(p.rows.length);e.id=l.nickname+"_overdue";var b=a.insertCell(0);l.expanded=(l.level<this.defaultDisplayLevel-1);var o=l.expanded?l.single_ontime:l.all_ontime;var k=l.expanded?l.single_overdue:l.all_overdue;l.hasOverdue=this.hasOverdue(k);var q=document.createElement("img");q.className="control";q.id=l.nickname+"Img";var g=document.createElement("a");g.appendChild(q);var n=l.children.length>0;if(n){g.nickname=l.nickname;g.findingSummary=this;g.onclick=function(){this.findingSummary.toggleNode(this.nickname);return false};q.src="/images/"+(l.expanded?"minus.png":"plus.png")}else{q.src="/images/leaf_node.png"}var d=document.createElement("div");d.className="treeTable"+l.level+(n?" link":"");d.appendChild(g);var s=document.createElement("img");s.className="icon";s.src="/images/"+l.icon+".png";g.appendChild(s);g.appendChild(document.createTextNode(l.label));g.appendChild(document.createElement("br"));g.appendChild(document.createTextNode(l.orgTypeLabel));b.appendChild(d);var m=1;for(r in o){count=o[r];cell=a.insertCell(m);if(r=="CLOSED"||r=="TOTAL"){cell.className="noDueDate"}else{cell.className="onTime"}this.updateCellCount(cell,count,l.nickname,l.orgType,r,"ontime",l.expanded);m+=1}for(r in k){count=k[r];cell=e.insertCell(e.childNodes.length);cell.className="overdue";this.updateCellCount(cell,count,l.nickname,l.orgType,r,"overdue",l.expanded)}a.style.display="none";e.style.display="none";if(l.level<this.defaultDisplayLevel){a.style.display="";if(l.hasOverdue){a.childNodes[0].rowSpan="2";a.childNodes[a.childNodes.length-2].rowSpan="2";a.childNodes[a.childNodes.length-1].rowSpan="2";e.style.display=""}}if(l.children.length>0){this.render(h,l.children)}}},toggleNode:function(a){node=this.findNode(a,this.treeRoot);if(node.expanded){this.collapseNode(node,true);this.hideSubtree(node.children)}else{this.expandNode(node);this.showSubtree(node.children,false)}},expandNode:function(f,b){f.ontime=f.single_ontime;f.overdue=f.single_overdue;f.hasOverdue=this.hasOverdue(f.overdue);var a=document.getElementById(f.nickname+"_ontime");var d=1;for(c in f.ontime){count=f.ontime[c];this.updateCellCount(a.childNodes[d],count,f.nickname,f.orgType,c,"ontime",true);d++}var e=document.getElementById(f.nickname+"_overdue");if(f.hasOverdue){d=0;for(c in f.overdue){count=f.overdue[c];this.updateCellCount(e.childNodes[d],count,f.nickname,f.orgType,c,"overdue",true);d++}}else{a.childNodes[0].rowSpan="1";a.childNodes[a.childNodes.length-2].rowSpan="1";a.childNodes[a.childNodes.length-1].rowSpan="1";e.style.display="none"}if(f.children.length>0){document.getElementById(f.nickname+"Img").src="/images/minus.png"}f.expanded=true;if(b&&f.children.length>0){this.showSubtree(f.children,false);for(var g in f.children){this.expandNode(f.children[g],true)}}},collapseNode:function(f,b){f.ontime=f.all_ontime;f.overdue=f.all_overdue;f.hasOverdue=this.hasOverdue(f.overdue);var a=document.getElementById(f.nickname+"_ontime");var d=1;for(c in f.ontime){count=f.ontime[c];this.updateCellCount(a.childNodes[d],count,f.nickname,f.orgType,c,"ontime",false);d++}var e=document.getElementById(f.nickname+"_overdue");if(b&&f.hasOverdue){a.childNodes[0].rowSpan="2";a.childNodes[a.childNodes.length-2].rowSpan="2";a.childNodes[a.childNodes.length-1].rowSpan="2";e.style.display="";d=0;for(c in f.all_overdue){count=f.all_overdue[c];this.updateCellCount(e.childNodes[d],count,f.nickname,f.orgType,c,"overdue",false);d++}}if(f.children.length>0){this.hideSubtree(f.children);document.getElementById(f.nickname+"Img").src="/images/plus.png"}f.expanded=false},hideSubtree:function(a){for(nodeId in a){node=a[nodeId];ontimeRow=document.getElementById(node.nickname+"_ontime");ontimeRow.style.display="none";overdueRow=document.getElementById(node.nickname+"_overdue");overdueRow.style.display="none";if(node.children.length>0){this.collapseNode(node,false);this.hideSubtree(node.children)}}},showSubtree:function(b,a){for(nodeId in b){node=b[nodeId];if(a&&node.children.length>0){this.expandNode(node);this.showSubtree(node.children,true)}ontimeRow=document.getElementById(node.nickname+"_ontime");ontimeRow.style.display="";overdueRow=document.getElementById(node.nickname+"_overdue");if(node.hasOverdue){ontimeRow.childNodes[0].rowSpan="2";ontimeRow.childNodes[ontimeRow.childNodes.length-2].rowSpan="2";ontimeRow.childNodes[ontimeRow.childNodes.length-1].rowSpan="2";overdueRow.style.display=""}}},collapseAll:function(){for(nodeId in this.treeRoot){node=this.treeRoot[nodeId];this.collapseNode(node,true);this.hideSubtree(node.children)}},expandAll:function(){for(nodeId in this.treeRoot){node=this.treeRoot[nodeId];this.expandNode(node,true)}},findNode:function(e,b){for(var d in b){node=b[d];if(node.nickname===e){return node}else{if(node.children.length>0){var a=this.findNode(e,node.children);if(a!==false){return a}}}}return false},hasOverdue:function(b){for(var a in b){if(b[a]>0){return true}}return false},updateCellCount:function(a,g,f,h,b,i,d){var e;if(!a.hasChildNodes()){if(g>0){e=document.createElement("a");e.href=this.makeLink(f,h,b,i,d);e.appendChild(document.createTextNode(g));a.appendChild(e)}else{a.appendChild(document.createTextNode("-"))}}else{if(a.firstChild.hasChildNodes()){if(g>0){a.firstChild.firstChild.nodeValue=g;a.firstChild.href=this.makeLink(f,h,b,i,d)}else{a.removeChild(a.firstChild);a.appendChild(document.createTextNode("-"))}}else{if(g>0){a.removeChild(a.firstChild);e=document.createElement("a");e.href=this.makeLink(f,h,b,i,d);e.appendChild(document.createTextNode(g));a.appendChild(e)}else{a.firstChild.nodeValue="-"}}}},makeLink:function(k,g,h,m,j){var f="";if(!(h=="CLOSED"||h=="TOTAL")){var b=new Date();var n=b.getFullYear()+"-"+(b.getMonth()+1)+"-"+b.getDate();if("ontime"==m){f="/nextDueDate/dateAfter/"+encodeURIComponent(n)}else{f="/nextDueDate/dateBefore/"+encodeURIComponent(n)}}var i="";if(h!==""&&h!=="TOTAL"){i="/denormalizedStatus/textExactMatch/"+encodeURIComponent(h)}var a="";if(!YAHOO.lang.isNull(this.filterType)&&this.filterType!==""){a="/type/enumIs/"+encodeURIComponent(this.filterType)}var d="";if(!YAHOO.lang.isNull(this.filterSource)&&this.filterSource!==""){d="/source/textExactMatch/"+encodeURIComponent(this.filterSource)}var e="/finding/remediation/list?q="+f+i+a+d;var l=YAHOO.lang.isValue(this.summaryView)?this.summaryView:"OHV";if(l==="POCV"){if(g==="poc"){e+="/pocUser/textExactMatch/"+encodeURIComponent(k)}else{e+="/pocOrg/organizationSubtree/"+encodeURIComponent(k)}}else{if(j){e+="/organization/textExactMatch/"+encodeURIComponent(k)}else{if(l==="SAV"){e+="/organization/systemAggregationSubtree/"+encodeURIComponent(k)}else{e+="/organization/organizationSubtree/"+encodeURIComponent(k)}}}return e},exportTable:function(d){var a=this.summaryView||"OHV";var b="/finding/summary/data/format/"+d+"/view/"+a+this.listExpandedNodes(this.treeRoot,"");document.location=b},listExpandedNodes:function(b,a){for(var e in b){var d=b[e];if(d.expanded){a+="/e/"+d.id;a=this.listExpandedNodes(d.children,a)}else{a+="/c/"+d.id}}return a}}};