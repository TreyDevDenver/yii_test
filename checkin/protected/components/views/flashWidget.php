<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
    	?>
    	<div class="alert alert-<?php echo $key ?> alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><?php echo ucfirst($key); ?>!</strong> <?php echo $message ?>
			</div>
    	<?php
    }
?>