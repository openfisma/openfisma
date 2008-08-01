<table  width="778" align="center" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="2"><div class="installer">
                <h4>Checking File and Directory Permissions</h4>
                <ul class="nolist">
                    <?php
                        foreach($this->writables as $f) {
                            echo '<li class="ok">', $f ,' is writable</li>';
                        }
                        foreach($this->notwritables as $f) {
                            echo '<li class="failure">', $f ,' is not writable</li>';
                        }
              ?>
                </ul>
            </div></td>
    </tr>
    <tr>
        <td width='50%' ><div class="back"><a class="button" href="<?php echo $this->back; ?>">Back</a></div></td>
        <td width='50%' ><div class="next"><?php if( empty( $this->next ) ) {
            echo '<button onclick="javascript:location.reload();">Refresh</button>';
        }else {
            echo "<a class='button' href=".$this->next." >Next</a>";
        }
      ?>
        </div></td>
    </tr>
</table>
