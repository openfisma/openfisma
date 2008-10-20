<?php
    $year_list = array(0     =>'All Fiscal Year',
                       '2005' =>'2005',
                       '2006' =>'2006',
                       '2007' =>'2007',
                       '2008' =>'2008',
                       '2009' =>'2009');
    $status_list = array('0'        =>'All Status',
                         'CLOSED' =>'Closed',
                         'OPEN'   =>'Open',
                         'NEW'    =>'New');
    $type_list = array('0'      =>'All Type',
                       'CAP'  =>'CAP',
                       'FP'   =>'FP',
                       'AR'   =>'AR');
    $this->system_list[0] ='--Any--';
    $this->source_list[0] ='--Any--';
    $url = "/panel/report/sub/poam/s/search";
?>
<div class="barleft">
<div class="barright">
<p><b>Plans of Actions And Milestones Report Administration</b></p>
</div>
</div>

<form name="poam_report" method="post" action="/panel/report/sub/poam/s/search">
<table width="95%" align="center" border="0" cellpadding="5" cellspacing="1" class="tipframe">
    <tr>
        <td width="6%" height="47"><b>System </b></td>
        <td width="21%">
        <?php echo $this->formSelect('system_id',
                                     isset($this->criteria['systemId'])?$this->criteria['systemId']:0, 
                                     null,$this->system_list);
              if( !empty($this->criteria['systemId']) ) {
                  $url .= '/system_id/'.$this->criteria['systemId'];
              }
        ?>
        </td>
        <td width="6%"><b>Source</b></td>
        <td width="18%">
        <?php echo $this->formSelect('source_id',
                                     isset($this->criteria['sourceId'])?$this->criteria['sourceId']:0, 
                                     null,$this->source_list);
              if( !empty($this->criteria['sourceId']) ) {
                  $url .= '/source_id/'.$this->criteria['sourceId'];
              }
        ?>
        </td>
        <td width="9%"><b>Fiscal Year</b></td>
        <td width="40%">
        <?php echo $this->formSelect('year',
                                     isset($this->criteria['year'])?$this->criteria['year']:0, 
                                     null,$year_list);
              if( !empty($this->criteria['year']) ) {
                  $url .= '/year/'.$this->criteria['year'];
              }
        ?>
        </td>
    </tr>
    <tr>
        <td height="30"><b>Type</b></td>
        <td>
        <?php echo $this->formSelect('type',
                                    (string)isset($this->criteria['type'])?$this->criteria['type']:0,
                                    null,$type_list);
              if( !empty($this->criteria['type']) ) {
                  $url .= '/type/'.$this->criteria['type'];
              }
        ?>
        </td>
        <td><b>Status</b></td>
        <td colspan="3">
        <?php echo $this->formSelect('status',
                                    (string)isset($this->criteria['status'])?$this->criteria['status']:0,
                                    null,$status_list);
              if( !empty($this->criteria['status']) ) {
                  $url .= '/status/'.$this->criteria['status'];
              }
        ?>
        </td>
    </tr>
    <?php
    if('overdue' == $this->flag){ ?>
    <tr>
        <td height="26"><b>Status</b></td>
        <td><?php echo $this->formSelect('status',$this->criteria['status'],null,$this->status_list);?>
        </td>
        <td><b>Overdue</b></td>
        <td colspan="3">
        <?php echo $this->formSelect('overdue',$this->criteria['overdue'],null,$this->overdue_list);?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td height="39" colspan="2"><input type="submit" name="search" value="Generate"></td>
    </tr>
</table>
</form>



<?php if( !empty($this->poam_list) ) { ?>

<div class="barleft">
<div class="barright">
<p><b>Poam Search Results</b>
    <span>
    <?php echo $this->links['all']; ?>
    <a target='_blank' href="<?php echo $url.'/format/pdf'; ?>"><img src="/images/pdf.gif" border="0"></a>
    <a href="<?php echo $url.'/format/xls'; ?>"><img src="/images/xls.gif" border="0"></a>
    </span>
</div>
</div>
<table width="95%" align="center" border="0" cellpadding=5" cellspacing="0" class="tbframe">
    <tr align="center">
        <th class="tdc">System</th>
        <th class="tdc">ID#</th>
        <th class="tdc">Description</th>
        <th class="tdc">Type</th>
        <th class="tdc">Status</th>
        <th class="tdc">Source</th>
        <th class="tdc">Server/Database</th>
        <th class="tdc">Location</th>
        <th class="tdc">Risk Level</th>
        <th class="tdc">Recommendation</th>
        <th class="tdc">Corrective Action</th>
        <th class="tdc">ECD</th>
        <th class="tdc">Control Y/N</th>
        <th class="tdc">Threats Y/N</th>
        <th class="tdc">Cmeasures Y/N</th>
    </tr>
    <?php 
        foreach($this->poam_list as  $row){ ?>
    <tr>
        <td class="tdc" align="center"><?php echo $this->system_list[$row['system_id']];?></td>
        <td class="tdc" align="center"><?php echo $row['id'];?></td>
        <td class="tdc"><?php echo $row['finding_data'];?></td>
        <td class="tdc" ><?php echo $row['type'];?></td>
        <td align='center' class='tdc'><?php echo $row['status'];?></td>
        <td class="tdc" align="center">
        <?php $id = &$row['source_id'];
            if( empty($id) ){
                echo 'N/A';
            }else{ 
                echo $this->source_list[$id];
            }
        ?>
        </td>
        <td class="tdc"><?php echo $row['ip'];?></td>
        <td class="tdc" >
        <?php $id = &$row['network_id'];
            if( empty($id) ){
                echo 'N/A';
            }else{ 
                echo $this->network_list[$id];
            }
        ?>
        </td>
        <td class="tdc" align="center"><?php echo $row['threat_level'];?></td>
        <td class="tdc"><?php echo $row['action_suggested'];?></td>
        <td class="tdc"><?php echo $row['action_planned'];?></td>
        <td class="tdc" align="center"><?php echo $row['action_est_date'];?></td>
        <td class="tdc"><?php echo (trim($row['blscr_id']) != '') ? 'Y' : 'N';?></td>
        <td class="tdc"><?php echo ($row['threat_level'] != 'NONE' && trim($row['threat_source']) != '' && trim($row['threat_justification']) != '') ? 'Y' : 'N';?></td>
        <td class="tdc"><?php echo ($row['cmeasure_effectiveness'] != 'NONE' && trim($row['cmeasure_effectiveness']) != '' && trim($row['cmeasure_justification']) != '') ? 'Y' : 'N';?></td>
    </tr>
    <?php } ?>
</table>

<?php } ?>