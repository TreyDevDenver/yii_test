<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <meta name="description" content="Yii 1.0 Example Check In App">
  <meta name="author" content="Trey Metrailer TreyDevDenver@gmail.com">

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap_custom.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
      	<?php 
      	$this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array(
							'label' => 'Check In', 
							'url' => array('/user/index')
						),
						array(
							'label' => 'Register', 
							'url' => array('/user/register'),
							'visible' => empty(Yii::app()->session['user_id'])
						),
						array(
							'label' => 'Your Points', 
							'url' => array('/user/checkins'),
							'visible' => !empty(Yii::app()->session['user_id'])
						),
					),
					'htmlOptions' => array(
						'class' => 'nav navbar-nav'
					)
				)); 
				?>
      </div>
    </div>
  </nav>

  <div class="container">
  	<?php echo $content; ?>
  </div>

  <footer class="pull-right">
		<?php echo Yii::powered(); ?>
	</footer>

	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
