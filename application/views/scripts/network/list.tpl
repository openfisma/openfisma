<div class="barleft">
<div class="barright">
<p><b>Network List</b>
</div>
</div>
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0" class="tbframe">
<tr align="center">
    <th>Network Name</th>
    <th>Nickname</th>
    <th>Description</th>
    <?php if(Config_Fisma::isAllow('admin_networks','update')){
              echo'<th>Edit</th>';
          } 
          if(Config_Fisma::isAllow('admin_networks','read')){
              echo'<th>View</th>';
          }
          if(Config_Fisma::isAllow('admin_networks','delete')){
              echo'<th>Del</th>';
          }
    ?>
</tr>
<?php foreach($this->network_list as $network){ ?>
<tr>
    <td class="tdc">&nbsp;<?php echo $network['name'];?></td>
    <td class="tdc">&nbsp;<?php echo $network['nickname'];?></td>
    <td class="tdc">&nbsp;<?php echo $network['desc'];?></td>
    <?php if(Config_Fisma::isAllow('admin_networks','update')){ ?>
    <td class="tdc" align="center">
        <a href="/panel/network/sub/view/v/edit/id/<?php echo $network['id'];?>" title="edit the Networks">
        <img src="/images/edit.png" border="0"></a>
    </td>
    <?php } if(Config_Fisma::isAllow('admin_networks','read')){ ?>
    <td class="tdc" align="center">
        <a href="/panel/network/sub/view/id/<?php echo $network['id'];?>" title="display the Networks">
        <img src="/images/view.gif" border="0"></a>
    </td>
    <?php } if(Config_Fisma::isAllow('admin_networks','delete')){ ?>
    <td class="tdc" align="center">
        <a href="/panel/network/sub/delete/id/<?php echo $network['id'];?>" title="delete the Networks, then no restore after deleted" onclick="return delok('Network');">
        <img src="/images/del.png" border="0"></a>
    </td>
    <?php }?>
</tr>
<?php }?>
</table>