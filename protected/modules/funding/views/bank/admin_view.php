<?php
	/* @var $this BankController */
	/* @var $model Bank */

$this->breadcrumbs=array(
	'Banks'=>array('adminmanage'),
	Yii::t('site', 'Detail Banks'),
);

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/office/grid-view.css');
?>

<? //begin.Messages ?>
<?php
	if(Yii::app()->user->hasFlash('success'))
		echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<? //end.Messages ?>
<?php $this->widget('application.components.system.BDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'bank_name',
	),
)); ?>
