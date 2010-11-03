<?php
// =====================
// = standard includes =
// =====================
require('../includes/basics.php');

$usr = checkUser();

// select for projects
$projectSel = makeSelectBox("pct",$kga['usr']['usr_grp']);

// select for events
$eventSel = makeSelectBox("evt",$kga['usr']['usr_grp']);


if (isset($_REQUEST['stopRecord'])) {
  stopRecorder();
}
if (isset($_REQUEST['startRecord']) &&
    isset($_REQUEST['project']) &&
    isset($_REQUEST['event'])) {

  $data= array();
  $data['lastProject'] = $_REQUEST['project'];
  $data['lastEvent']   = $_REQUEST['event'];
  usr_edit($kga['usr']['usr_ID'],$data);
  $kga['usr']['lastProject'] = $data['lastProject'];
  $kga['usr']['lastEvent'] = $data['lastEvent'];

  startRecorder($_REQUEST['project'],$_REQUEST['event'],$kga['usr']['usr_ID']);
}

?>
<html>
  <head>
    <title></title>
    <meta content="">
    <style>
    body {
      /*background-color:black;*/
      background:url('../grfx/ki_twitter_bg.jpg') no-repeat;
      background-color:#43e820;
    }
    label,select {
      display:block;
    }
    </style>
  </head>
  <body>

<?php
if (get_rec_state($kga['usr']['usr_ID']) == 0) {
?>
<form method="post">

<label for="project"><?= $kga['lang']['pct']?></label>
<select name="project">
<?php
for ($i=0;$i<count($projectSel[0]);$i++) {
  $value = $projectSel[1][$i];
  $name = $projectSel[0][$i];
  $selected = $kga['usr']['lastProject']==$value?'selected = "selected"':'';
  echo "<option $selected value=\"$value\">$name</option>";
}
?>
</select>

<label for="event"><?= $kga['lang']['evt']?></label>
<select name="event">
<?php
for ($i=0;$i<count($eventSel[0]);$i++) {
  $value = $eventSel[1][$i];
  $name = $eventSel[0][$i];
  $selected = $kga['usr']['lastProject']==$value?'selected = "selected"':'';
  echo "<option $selected value=\"$value\">$name</option>";
}
?>
</select>

<input type="submit" name="startRecord" value="<?= $kga['lang']['start']?>"/>

</form>
<?php
}
else {
?>
<form method="post">

<label><?= $kga['lang']['pct']?></label>
<?php
  $last_pct = pct_get_data($kga['usr']['lastProject']);
  echo "<b>".$last_pct['pct_name']."</b>";
?>
<label><?= $kga['lang']['evt']?></label>
<?php
  $last_evt = evt_get_data($kga['usr']['lastEvent']);
  echo "<b>".$last_evt['evt_name']."</b>";
?>
  
<br/>
<br/>
<input type="submit" name="stopRecord" value="<?= $kga['lang']['stop']?>"/>

</form>
<?php
}
?>
</body>
</html>