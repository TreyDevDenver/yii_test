<?php
/* @var $this UserController */

$this->pageTitle=Yii::app()->name . ' - Your Points';

// format the check total
$displayCheckins = $checkinMetrics['total_checkins'] . ' time';
if ($checkinMetrics['total_checkins'] > 1) {
	$displayCheckins .= 's';
}
?>

<div class="jumbotron">
	<h1>Your Points</h1>
	<p>You have checked in <?php echo $displayCheckins ?> and earned <?php echo $checkinMetrics['total_points'] ?> points.</p>
</div>
