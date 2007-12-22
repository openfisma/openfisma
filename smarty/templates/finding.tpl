
{include file="header.tpl" title="OVMS" name="Finding Summary"}
{literal}
<script language="javascript" src="javascripts/func.js"></script>
<script language="javascript">
function pageskip(flag) {
	var pageno = parseInt(document.finding.pageno.value);

	if(flag) {
		pageno = pageno + 1; // next page
	}
	else {
		pageno = pageno - 1; // prev page
	}

	if(pageno < 1)		
		pageno = 1; // first page
	
	document.finding.pageno.value = pageno;

	document.finding.submit();
}

function dosearch() {
	document.finding.sbt.value = 'search';
	document.finding.fn.value = 'date';
	document.finding.asc.value = 1;
	document.finding.pageno.value = 1;
	return true;
}

function order_page(fd, asc) {
	document.finding.sbt.value = 'search';
	document.finding.fn.value = fd;
	document.finding.asc.value = asc;
	return true;
}

function findingdetail(fid, func) {
	document.finding.act.value = func;
	document.finding.fid.value = fid;
	//alert(document.finding.action);
	document.finding.action = "findingdetail.php";
	return true;
}
</script>
{/literal}

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbline">
<tr>
	<td valign="bottom"><!--<img src="images/greenball.gif" border="0"> -->
<b>Findings:</b> Summary</td>
	<td align="right" valign="bottom">{$now}</td>
</tr>
</table>

{if $view_right eq 1 or $del_right eq 1 or $edit_right eq 1}
<br>
<table width="800" border="0" cellpadding="0" cellspacing="0" class="tbframe">
<tr align="center">
	<th>System</td>
	<th>Open(Today)</td>
	<th>30(Days)</td>
	<th>60(Days)</td>
	<th>More Days</td>

	<th>Remediation</td>
	<th>Closed</td>
	<th>Total</td>
</tr>

{section name=row loop=$summary_data}
<tr align="right">
	<td class="tdc" align="left">&nbsp;{$summary_data[row].system}</td>
	<td class="tdc">&nbsp;{$summary_data[row].open}&nbsp;</td>
	<td class="tdc">&nbsp;{$summary_data[row].thirty}&nbsp;</td>
	<td class="tdc">&nbsp;{$summary_data[row].sixty}&nbsp;</td>
	<td class="tdc">&nbsp;{$summary_data[row].ninety}&nbsp;</td>

	<td class="tdc">&nbsp;{$summary_data[row].reme}&nbsp;</td>
	<td class="tdc">&nbsp;{$summary_data[row].closed}&nbsp;</td>
	<td class="tdc">&nbsp;{$summary_data[row].total}&nbsp;</td>
</tr>
{/section}
</table>

<br>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbline">
<tr>
	<td valign="bottom"><!--<img src="images/greenball.gif" border="0"> --><b>Findings:</b> Filters</td>
</tr>
</table>


<br>
<form name="finding" method="post" action="finding.php">
<input type="hidden" name="sbt" value="{$submit}">
<input type="hidden" name="act" value="view">
<input type="hidden" name="fid" value="0">
<input type="hidden" name="fn" value="{$fn}">
<input type="hidden" name="asc" value="{$asc}">
<table border="0" cellpadding="3" cellspacing="1" class="tipframe">
<tr>
	<td>
	<table border="0" cellpadding="3" cellspacing="1">
	<tr>
		<td align="right">Status:</td>
		<td><select name="status">
			<option value="">--Any--</option>
			<option value="OPEN"{if $status eq "OPEN"} selected{/if}>Open</option>
			<option value="REMEDIATION"{if $status eq "REMEDIATION"} selected{/if}>Remediation</option>
<!--			<option value="consolidated"{if $status eq "consolidated"} selected{/if}>Consolidated</option>-->
			<option value="CLOSED"{if $status eq "CLOSED"} selected{/if}>Closed</option>
<!--			<option value="DELETED"{if $status eq "DELETED"} selected{/if}>Deleted</option>-->
			</select></td>
		<td align="right">Source:</td>
		<td><select name="source">
			<option value="">--Any--</option>
			{foreach from=$source_list key=sid item=sname}
			{if $sid eq $source }
			<option value="{$sid}" selected>{$sname}</option>
			{else}
			<option value="{$sid}">{$sname}</option>
			{/if}
			{/foreach}
			</select></td>
		<td align="right">System:</td>
		<td><select name="system">
			<option value="">--Any--</option>
			{foreach from=$system_list key=sid item=sname}
			{if $sid eq $system }
			<option value="{$sid}" selected>{$sname}</option>
			{else}
			<option value="{$sid}">{$sname}</option>
			{/if}
			{/foreach}
			</select></td>
		<td align="right">Vulnerability:</td>
		<td><input type="text" name="vulner" value="{$vulner}" maxlength="20"></td>
	</tr>
	<tr>
		<td align="right">Product:</td>
		<td><input type="text" name="product" value="{$product}" maxlength="20"></td>
		<td align="right">Network:</td>
		<td><select name="network">
			<option value="">--Any--</option>
			{foreach from=$network_list key=sid item=sname}
			{if $sid eq $network }
			<option value="{$sid}" selected>{$sname}</option>
			{else}
			<option value="{$sid}">{$sname}</option>
			{/if}
			{/foreach}
			</select></td>
		<td align="right">IP Address:</td>
		<td><input type="text" name="ip" value="{$ip}" maxlength="20" maxlength="20"></td>
		<td align="right">Port:</td>
		<td><input type="text" name="port" value="{$port}" size="6" maxlength="6"></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table border="0" cellpadding="3" cellspacing="1">
	<tr>
		<td>Date Discovered</td>
		<td>&nbsp;</td>
		<td>From:</td>
		<td><input type="text" name="startdate" size="12" maxlength="10" value="{$startdate}"></td>
		<td><span onclick="javascript:show_calendar('finding.startdate');"><img src="images/picker.gif" width=24 height=22 border=0></span></td>
		<td>&nbsp;</td>
		<td>To:</td>
		<td><input type="text" name="enddate" size="12" maxlength="10" value="{$enddate}"></td>
		<td><span onclick="javascript:show_calendar('finding.enddate');"><img src="images/picker.gif" width=24 height=22 border=0></span></td>
		<td>&nbsp;</td>
		<td><input type="image" name="search" src="images/button_search.png" border="0" onclick="dosearch();"></td>
		<!--<td><input type="submit" name="submit" value="Search"></td>-->
	</tr>
	</table>
	</td>
</tr>
</table>


<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbline">
<tr>
	<td valign="bottom"><!--<img src="images/greenball.gif" border="0"> --><b>Findings:</b> List</td>
	<td align="right" valign="bottom">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>Total pages: {$totalpage} &nbsp;&nbsp;</td>
		<td><span {if $pageno ne 1}style="cursor: pointer" onclick="pageskip(false);"{/if}><img src="images/button_prev.png" border="0"></span></td>
		<td>&nbsp;Page:</td>
		<td><input type="text" name="pageno" value="{$pageno}" size="5" maxlength="5" readonly="yes">&nbsp;</td>
		<td><span {if $nextpage eq 1 && $pageno lt $totalpage}style="cursor: pointer" onclick="pageskip(true);"{/if}><img src="images/button_next.png" border="0"></span></td>
	</tr>
	</table>
	</td>
</tr>
</table>

<br>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
	{if $del_right eq 1}
	<!--<input type="button" name="all" value="Select All" onclick="selectall(5, true);">&nbsp;
	<input type="button" name="none" value="Select None" onclick="selectall(5, false);">-->
	<span style="cursor: pointer"><img src="images/button_select_all.png" border="0" onclick="selectall('finding', 'fid_', true);"></span>&nbsp;
	<span style="cursor: pointer"><img src="images/button_select_none.png" border="0" onclick="selectall('finding', 'fid_', false);"></span>
	{/if}
	</td>
	
	<td align="right">
	{if $del_right eq 1}
	<!--<input type="submit" name="submit" value="Consolidate">&nbsp;
	<input type="submit" name="submit" value="Delete">-->
	<!--<input type="image" name="consolodate" src="images/button_consolidate.png" border="0">&nbsp;-->
	<span style="cursor: pointer"><img src="images/button_delete.png" border="0" onclick="document.finding.sbt.value='delete'; return deleteconfirm('finding','fid_','finding');"></span>
	{/if}
	</td>
</tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbframe">
<tr align="center">
	<th>&nbsp;</td>
	<th nowrap>ID <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('id', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('id', 1)"></th>
	<th nowrap>Status <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('status', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('status', 1)"></td>
	<th nowrap>Source <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('source', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('source', 1)"></td>
	<th nowrap>System <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('system', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('system', 1)"></td>
	<th nowrap>Network <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('network', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('network', 1)"></td>

	<th nowrap>IP Address <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('ip', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('ip', 1)"></td>
	<th nowrap>Port <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('port', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('port', 1)"></td>
	<th nowrap>Product <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('product', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('network', 1)"></td>
	<th nowrap>Vulnerabilities <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('vulner', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('vulner', 1)"></td>
	<th nowrap>Date Discovered <input type="image" src="images/up_arrow.gif" border="0" onClick="order_page('date', 0)"> <input type="image" src="images/down_arrow.gif" border="0" onClick="order_page('date', 1)"></td>

	{if $edit_right eq 1}
	<!--edit right-->
	<th nowrap>Edit</td>
	{/if}
	
	{if $view_right eq 1}
	<!--view right-->
	<th nowrap>View</td>
	{/if}
</tr>

{foreach key=fname item=fobj from=$filter_data}
<tr>
	<td align="center" class="tdc">
	{if $del_right eq 1}
	<input type="checkbox" name="fid_{$fobj->finding_id}" value="fid.{$fobj->finding_id} ">
	{/if}
	</td>
	<td align="center" class="tdc">{$fobj->finding_id}</td>
	<td class="tdc">{$fobj->finding_status}&nbsp;</td>
	<td class="tdc">{$fobj->source_name}&nbsp;</td>
	<td class="tdc"><span title="{foreach item=sname from=$fobj->asset_obj->system_arr}||{$sname}{/foreach}">{$fobj->asset_obj->system_arr[0]}</span>&nbsp;</td>
	<td class="tdc"><span title="{foreach item=sname from=$fobj->asset_obj->network_arr}||{$sname}{/foreach}">{$fobj->asset_obj->network_arr[0]}</span>&nbsp;</td>

	<td class="tdc"><span title="{foreach item=sname from=$fobj->asset_obj->ip_arr}||{$sname}{/foreach}">{$fobj->asset_obj->ip_arr[0]}</span>&nbsp;</td>
	<td class="tdc"><span title="{foreach item=sname from=$fobj->asset_obj->port_arr}||{$sname}{/foreach}">{$fobj->asset_obj->port_arr[0]}</span>&nbsp;</td>
	<td class="tdc">{$fobj->asset_obj->prod_name}&nbsp;</td>
	<td class="tdc"><span title="{foreach item=sname from=$fobj->vulner_arr}||{$sname}{/foreach}">{$fobj->vulner_brief}</span>&nbsp;</td>
	<td class="tdc" align="center">{$fobj->finding_date_discovered}&nbsp;</td>

	{if $edit_right eq 1}
	<!--edit right-->
	<td class="tdc" align="center"><input type="image" src="images/edit.png" border="0" onClick="findingdetail({$fobj->finding_id}, 'edit')"></td>
	<!--<td class="tdc" align="center"><a href="findingdetail.php?fid={$fobj->finding_id}&act=edit&fn={$fn}{$nurl}"><img src="images/edit.png" border="0"></a></td>-->
	{/if}
	
	{if $view_right eq 1}
	<!--view right-->
	<td class="tdc" align="center"><input type="image" src="images/view.gif" border="0" onClick="findingdetail({$fobj->finding_id}, 'view')"></td>
	<!--<td class="tdc" align="center"><a href="findingdetail.php?fid={$fobj->finding_id}&act=view&fn={$fn}{$nurl}"><img src="images/view.gif" border="0"></a></td>-->
	{/if}

</tr>
{/foreach}
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<td>
	{if $del_right eq 1}
	<!--delete right-->
	<span style="cursor: pointer"><img src="images/button_select_all.png" border="0" onclick="selectall('finding', 'fid_', true);"></span>&nbsp;
	<span style="cursor: pointer"><img src="images/button_select_none.png" border="0" onclick="selectall('finding', 'fid_', false);"></span>
	{/if}
	</td>
	<td align="right">
	{if $del_right eq 1}
	<!--delete right-->
	<!--<input type="submit" name="submit" value="Consolidate">&nbsp;
	<input type="submit" name="submit" value="Delete">-->
	<!--<input type="image" name="consolidate" src="images/button_consolidate.png" border="0">&nbsp;-->
	<span style="cursor: pointer"><img src="images/button_delete.png" border="0" onclick="document.finding.sbt.value='delete'; return deleteconfirm('finding','fid_','finding');"></span>
	<!--<input type="image" name="delete" src="images/button_delete.png" border="0" onclick="document.finding.submit.value='Delete'; document.finding.submit();">-->
	{/if}
	</td>
</tr>
</table>
</form>

{else}
<p>No right do your request.</p>
{/if}
<p>&nbsp;</p>

{include file="footer.tpl"}
