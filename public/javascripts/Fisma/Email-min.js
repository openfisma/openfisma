Fisma.Email=function(){return{panelElement:null,showRecipientDialog:function(){if(Fisma.Email.panelElement!==null&&Fisma.Email.panelElement instanceof YAHOO.widget.Panel){Fisma.Email.panelElement.removeMask();Fisma.Email.panelElement.destroy();Fisma.Email.panelElement=null}var c=document.createElement("div");var f=document.createElement("p");var b=document.createTextNode("* Target E-mail Address:");f.appendChild(b);c.appendChild(f);var d=document.createElement("input");d.id="testEmailRecipient";d.name="recipient";c.appendChild(d);var e=document.createElement("div");e.style.height="10px";c.appendChild(e);var a=document.createElement("input");a.type="button";a.id="dialogRecipientSendBtn";a.style.marginLeft="10px";a.value="Send";c.appendChild(a);Fisma.Email.panelElement=Fisma.HtmlPanel.showPanel("Test E-mail Configuration",c.innerHTML);document.getElementById("dialogRecipientSendBtn").onclick=Fisma.Email.sendTestEmail},sendTestEmail:function(){if(document.getElementById("testEmailRecipient").value===""){alert("Recipient is required.");document.getElementById("testEmailRecipient").focus();return false}var c=document.getElementById("testEmailRecipient").value;var b=document.getElementById("email_config");b.elements.recipient.value=c;var a=document.getElementById("sendTestEmail");spinner=new Fisma.Spinner(a.parentNode);spinner.show();YAHOO.util.Connect.setForm(b);YAHOO.util.Connect.asyncRequest("POST","/config/test-email-config/format/json",{success:function(e){var d=YAHOO.lang.JSON.parse(e.responseText);message(d.msg,d.type,true);spinner.hide()},failure:function(d){alert("Failed to send test mail: "+d.statusText);spinner.hide()}},null);if(Fisma.Email.panelElement!==null&&Fisma.Email.panelElement instanceof YAHOO.widget.Panel){Fisma.Email.panelElement.removeMask();Fisma.Email.panelElement.destroy();Fisma.Email.panelElement=null}return true}}}();