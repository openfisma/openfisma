<div class="barleft">
<div class="barright">
<p><b>Administration: Rights Assignment</b>
</div>
</div>
<form method="post" action="/role/right/id/<?php echo $this->role['id'];?>/do/update" 
    name="assign_right">
<fieldset style="border: 1px solid rgb(68, 99, 122);">
    <legend><b><font size="3px"><?php echo $this->role['name'];?></font></b></legend>
    <table height="250" border="0" style="margin-left:80px">
        <tr>
            <td><b>Screen Names</b></td>
            <td><b>Available Functions</b></td>
            <td></td>
            <td><b>Assigned Functions</b></td>
        </tr>
        <tr>
            <td width="254">
                <select multiple size="20" id="function_screen" name="function_screen" style="width:200px" url="/role/right/id/<?php echo $this->role['id'];?>">
                <?php foreach($this->screen_list as $row){ ?>
                    <option value="<?php echo $row['screen_name'];?>" title="<?php echo $row['screen_name'];?>">
                        <?php echo $row['screen_name'];?>
                    </option>
                <?php } ?>
                </select>
            </td>
            <td><select multiple size="20" id="available_functions" name="available_functions" style="width:250px"></select></td>
            <td width="54" valign="top">
                <br>
                <input type="button" value="   ->   "  id="add_function">
                <br><br>
                <input type="button" value="   <-   " id="remove_function">
            </td>
            <td><select multiple size="20" id="exist_functions" name="exist_functions[]" style="width:250px">
                <?php foreach($this->exist_functions as $row){ ?>
                    <option value="<?php echo $row['function_id'];?>" title="<?php echo $row['function_name'];?>">
                        <?php echo $row['function_name'];?>
                    </option>
                <?php } ?>
            </select></td>
        </tr>
    </table>
</fieldset>
<br>
<table border="0" width="300" align="center">
    <tr align="center">
        <td><input type="submit" value="Update"></td>
        <td><input type="reset" onClick="document.assign_right.reset();" value="Reset"></td>
    </tr>
</table>
</form>