Fisma.Remediation={upload_evidence:function(){Fisma.UrlPanel.showPanel("Upload Evidence","/finding/remediation/upload-form",Fisma.Remediation.upload_evidence_form_init);return false},upload_evidence_form_init:function(){document.finding_detail_upload_evidence.action=document.finding_detail.action},remediationAction:function(c,j){var g=j.action;var q=j.formId;var l=j.panelTitle;var h=j.findingId;if("REJECTED"===g){var a=Fisma.UrlPanel.showPanel(l,"/finding/remediation/reject-evidence/id/"+h,function(){document.finding_detail_reject_evidence.action=document.finding_detail.action;document.getElementById("dialog_close").onclick=function(){a.destroy();return false}})}else{var i=document.createElement("div");var n=document.createElement("div");n.className="messageBox attention";var f="WARNING: This action cannot be undone.";n.appendChild(document.createTextNode(f));i.appendChild(n);var d=document.createElement("p");var k;if("APPROVED"===g){k=document.createTextNode("Comments (OPTIONAL):")}else{k=document.createTextNode("Comments:")}d.appendChild(k);i.appendChild(d);var o=document.createElement("textarea");o.id="dialog_comment";o.name="comment";o.rows=5;o.cols=60;i.appendChild(o);var b=document.createElement("div");b.className="buttonBar";i.appendChild(b);var m=document.createElement("button");m.id="dialog_continue";m.appendChild(document.createTextNode("Confirm"));b.appendChild(m);var e=document.createElement("button");e.id="dialog_close";e.style.marginLeft="5px";e.appendChild(document.createTextNode("Cancel"));b.appendChild(e);var a=Fisma.HtmlPanel.showPanel(l,i.innerHTML);document.getElementById("dialog_continue").onclick=function(){var p=document.getElementById(q);var u=document.getElementById("dialog_comment").value;if("DENIED"===g){if(u.match(/^\s*$/)){var t="Comments are required.";var r={zIndex:10000};Fisma.Util.showAlertDialog(t,r);return}}p.elements.comment.value=u;p.elements.decision.value=g;var s=document.createElement("input");s.type="hidden";s.name="submit_msa";s.value=g;p.appendChild(s);p.submit();return};document.getElementById("dialog_close").onclick=function(){a.destroy();return false}}return true},add_upload_evidence:function(){var a=document.getElementById("evidence_upload_file_list");var b=document.createElement("input");b.type="file";b.name="evidence[]";b.multiple=true;a.appendChild(b);return false},show_rejected_evidences:function(){var a=document.getElementById("rejectedEvidencesContainer");var b=document.getElementById("rejectedEvidencesTrigger-button");if(a.style.display!="block"){a.style.display="block";b.innerHTML="Click to hide"}else{a.style.display="none";b.innerHTML="Click to display"}},reject_evidence_validate:function(){if(document.finding_detail_reject_evidence.comment.value.match(/^\s*$/)){var b="Comments are required.";var a={zIndex:10000};Fisma.Util.showAlertDialog(b,a);return false}return true}};