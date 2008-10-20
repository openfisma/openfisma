
<form method="post" action="<?php echo $this->next;?>">
    <table align="center" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2"><div class="installer">
                    <h4>General Settings</h4>
                    <table cellspacing='5' >
                        <tr valign='top' align='left'>
                            <td class='head'><b>Database Product</b></td>
                            <td class='even'><select  size='1' name='dsn[type]' id='database'>
                                    <option value='mysql' selected='selected'>mysql</option>
                                </select>                            </td>
                        </tr>
                        <tr valign='top' align='left'>
                            <td class='head'><b> Host Address/Name</b><br />
                                <span style='font-size:85%;'>i.e localhost or 192.168.1.1</span> </td>
                            <td class='even'><input type='text' name='dsn[host]' id='host' size='30' maxlength='100' value="<?php echo $this->dsn['host']?>" />
                            <?php if(isset($this->message['host'])) {echo " <span class='notice'>*</span>";}?></td>
                        </tr>
                        <tr valign='top' align='left'>
                            <td class='head'><b> Database Port</b></td>
                            <td class='even'><input type='text' name='dsn[port]' id='port' size='30' maxlength='100' value="<?php echo $this->dsn['port']?>" /> <?php if(isset($this->message['port'])) {echo " <span class='notice'>*</span>";}?></td>
                        </tr>
                        <tr valign='top' align='left'>
                            <td class='head'><b>Database Username</b><br />
                                <span style='font-size:85%;'>User account must be able to create databases.</span> </td>
                            <td class='even'><input type='text' name='dsn[uname]' id='uname' size='30' maxlength='100' value="<?php echo isset($this->dsn['uname'])? $this->dsn['uname']:''?>" />
                            <?php if(isset($this->message['uname'])) {echo " <span class='notice'>*</span>";}?></td>
                        </tr>
                        <tr valign='top' align='left'>
                            <td class='head'><b>Database Password</b><br />
                                <span style='font-size:85%;'>Password for user account above.</span> </td>
                            <td class='even'><input type='password' name='dsn[upass]' id='upass' size='30' maxlength='100'  value="<?php echo isset($this->dsn['upass'])? $this->dsn['upass']:''?>"/>
                            <?php if(isset($this->message['upass'])) {echo " <span class='notice'>*</span>";}?></td>
                        </tr>
                        <tr valign='top' align='left'>
                            <td class='head'><b>Database Name</b><br />
                                <span style='font-size:85%;'> Name of database, the installer will
                                attempt to create the database if it does not exist</span> </td>
                            <td class='even'><input type='text' name='dsn[dbname]' id='dbname' size='30' maxlength='100'  value="<?php echo isset($this->dsn['dbname'])?$this->dsn['dbname']:'';?>" />
                                <?php if(isset($this->message['dbname'])) {echo " <span class='notice'>*</span>";}?>                            </td>
                        </tr>
                    </table>
                </div>
        </tr>
        <tr>
            <td width='50%'><div class="back"><a class="button" href="<?php echo $this->back; ?>" >Back</a></div></td>
            <td width="50%"><div class="next">
                    <input class="button" type='submit' name='submit' value='Next' />
                </div></td>
        </tr>
    </table>
</form>