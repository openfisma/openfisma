<?php
$fid_array = array('name'=>'Network Name','nickname'=>'Nickname');
$this->declareVars(array('fid'=>'name')); //set the default selected item
?>
<div class="barleft">
<div class="barright">
<p><b> Network Administration</b>
</div>
</div>
<table class="tbframe" align="center"  width="98%">
    <tbody>
        <tr>
            <th>[<a id="network_list" href="/panel/network/sub/list"> Network List</a>] (total: <?php echo $this->total;?>)</th>
            <th>[<a id="add_network" href="/panel/network/sub/create" title="Add  Network">Add 
 Network</a>]</th>
            <th>
                <table align="center">
                    <tbody>
                        <tr height="22">
                            <td><b>Page:&nbsp;</b></td>
                            <td><?php echo $this->links['all'];?></td>
                            <td>|</td>
                        </tr>
                    </tbody>
                </table>
            </th>
            <th>
                <table align="center">
                <form name="query" method="post" action="/panel/network/sub/list">
                    <tbody>
                        <tr>
                            <td><b>Query:&nbsp;</b></td>
                            <td><?php echo $this->formSelect('fid',$this->fid,null,$fid_array);?></td>
                            <td><input name="qv" value="<?php echo $this->qv;?>" title="Input your query value" size="10" maxlength="40" type="text"></td>

                             <td><input value="Search" title="submit your request" type="submit"></td>
                        </tr>
                    </tbody>
                </form>
                </table>
            </th>
        </tr>
    </tbody>
</table>