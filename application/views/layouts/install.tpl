<?php
    echo $this->doctype();
?>
<html>
<head>
  <title>OpenFISMA Custom Installation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style type="text/css" media="all">
  <!-- @import url(/stylesheets/install.css); -->
  </style>
  <link rel="icon"
        type="image/ico"
        href="/images/favicon.ico" />
</head>
<body> 

<div class="panel">
<table  align="center"  cellpadding="0" cellspacing="0" >
  <tr height=23>
    <td width="180"><img src="/images/install/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="448" background="/images/install/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="/images/install/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
  <tr height=80>
    <td width="180" bgcolor="#FFFFFF" align=right>
    <a href="<?php echo $this->url(array(2=>'index'),'default'); ?>">
                <img src="/images/install/OpenFISMA.gif" alt="OpenFISMA Logo" /></a></td>
    <td width="448" bgcolor="#FFFFFF" >&nbsp;</td>
    <td width="150" bgcolor="#FFFFFF" >&nbsp;</td>
  </tr>
  <tr height=23>
    <td width="180"><img src="/images/install/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="448" background="/images/install/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="/images/install/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
</table>

   <?php echo $this->layout()->CONTENT ; ?> 
        <table cellspacing="0" align="center" cellpadding="0">
          <tr>
            <td width="150"><img src="/images/install/hbar_left.gif" ></td>
            <td width="478" background="/images/install/hbar_middle.gif">&nbsp;</td>
            <td width="150"><img src="/images/install/hbar_installer_right.gif" ></td>
          </tr>
        </table>
</div>

</body>
</html>