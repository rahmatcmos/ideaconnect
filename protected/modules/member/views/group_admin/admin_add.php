<?php
	/* @var $this GroupadminController */
	/* @var $model CcnGroupAdmin */

	$this->pageTitle = Yii::t('site', 'Tambah Grup Admin');
?>

<?php echo $this->renderPartial('/group_admin/_form', array('model'=>$model)); ?>