<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>OpenFISMA Custom Installation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style type="text/css" media="all">
  <!-- @import url(<?php echo burl(); ?>/stylesheets/install.css); -->
  </style>
  <link rel="icon"
        type="image/ico"
        href="<?php echo burl()?>/images/favicon.ico" />
</head>
<body> 

<div class="panel">
<table  align="center"  cellpadding="0" cellspacing="0" >
  <tr height=23>
    <td width="180"><img src="<?php echo burl()?>/images/install/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="448" background="<?php echo burl()?>/images/install/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="<?php echo burl()?>/images/install/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
  <tr height=80>
    <td width="180" bgcolor="#FFFFFF" align=right>
    <a href="<?php echo $this->url(array(2=>'index'),'default'); ?>">
                <img src="<?php echo burl()?>/images/install/OpenFISMA.gif" alt="OpenFISMA Logo" /></a></td>
    <td width="448" bgcolor="#FFFFFF" >&nbsp;</td>
    <td width="150" bgcolor="#FFFFFF" >&nbsp;</td>
  </tr>
  <tr height=23>
    <td width="180"><img src="<?php echo burl()?>/images/install/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="448" background="<?php echo burl()?>/images/install/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="<?php echo burl()?>/images/install/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
</table>

   <?php echo $this->layout()->CONTENT ; ?> 
        <table cellspacing="0" align="center" cellpadding="0">
          <tr>
            <td width="150"><img src="<?php echo burl()?>/images/install/hbar_left.gif" ></td>
            <td width="478" background="<?php echo burl()?>/images/install/hbar_middle.gif">&nbsp;</td>
            <td width="150"><img src="<?php echo burl()?>/images/install/hbar_installer_right.gif" ></td>
          </tr>
        </table>
</div>

</body>
</html>
