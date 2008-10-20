<?php
$fid_array = array('name'=>'Product Name',
                   'vendor'=>'Vendor',
                   'version'=>'Version');
$this->declareVars(array('fid'=>'name'));

?>
<div class="barleft">
<div class="barright">
<p><b>Product Administration</b><span>
</div>
</div>
<table class="tbframe" align="center"  width="98%">
    <tbody>
        <tr>
            <th>[<a href="/panel/product/sub/list">Products List</a>] (total: <?php echo 
$this->total;?>)</th>
            <th>[<a href="/panel/product/sub/create" title="Add New Product">Add 
Product</a>]</th>
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
                <form name="query" method="post" action="/panel/product/sub/list">
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