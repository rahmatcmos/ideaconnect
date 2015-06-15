<?php
	$this->pageTitle='Konten: ' . ($section != null ? $section->title : '') . ($category != null ? $category->title : '');
	$this->breadcrumbs=array(
		'Kelola',
	);

	$cs = Yii::app()->getClientScript();
	$multipleDeleteUrl = Yii::app()->createUrl('vacancy/admin/adminmultipledelete');
$js=<<<EOP
	$('.check-all').click(function(){
		if ($('.check-all').text() == 'CCheck All') {
			$('.check-for-delete').attr('checked', true);
			//$('.deleteSelected').show();
			$('.check-all').html('<span class="icons">C</span>Uncheck All');
		} else {
			$('.check-for-delete').attr('checked', false);
			//$('.deleteSelected').hide();
			$('.check-all').html('<span class="icons">C</span>Check All');
		}
	});
	$('.delete-selected').click(function(){
		var id = new Array();
		var a = 0;
		$(".check-for-delete:checked").each(function(){
			id[a] = $(this).val();
			a++;
		});
		if (a == 0)
			alert('Belum ada lowongan yang dipilih untuk dihapus!');
		else {
			var listId = id.join(',');
			$.ajax({
				type:'post',
				url:'$multipleDeleteUrl',
				data: {'listId':listId},
				success: function(r){
					if (r == 0)
						alert('Gagal melakukan penghapusan');
					else if (r == 1) {
						alert('Sukses menghapus data lowongan');
						
						// Refresh page, belum bisa delete spesific row setelah delete via ajax :)
						location.reload();
					}
				}		
			});
		}
	});
EOP;
	$cs->registerScript('search', $js, CClientScript::POS_END);
?>

<?php //begin.Messages ?>
<div id="ajax-message">
<?php
	if(Yii::app()->user->hasFlash('error'))
		echo Utility::flashError(Yii::app()->user->getFlash('error'));
	if(Yii::app()->user->hasFlash('success'))
		echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
</div>
<?php //end.Messages ?>

<?php //begin.Search ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php //end.Search ?>

<?php //begin.Grid Option ?>
<div class="grid-option">
<?php $this->renderPartial('_option_form',array(
	'model'=>$model,
)); ?>
</div>
<?php //end.Grid Option ?>

<?php //begin.Grid Item ?>
<?php
	
	Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_modified').datepicker();
}
");
	 
	$columnData   = $columns;
	array_push($columnData, array(
		'header' => 'Opsi',
		'class'=>'CButtonColumn',
		'buttons' => array(
			'view' => array(
				'label' => 'lihat',
				'options' => array(
					//'rel' => 600, 
					'class' => 'view'
				),
				//'click' => 'dialogUpdate',
				'url' => 'Yii::app()->controller->createUrl("adminview",array("id"=>$data->primaryKey, "sid"=>$data->section_id))'),
			'update' => array(
				'label' => 'ubah',
				'options' => array(
					//'rel' => 600, 
					'class' => 'update'
				),
				//'click' => 'dialogUpdate',
				'url' => 'Yii::app()->controller->createUrl("adminedit",array("id"=>$data->primaryKey, "sid"=>$data->section_id))'),
			'delete' => array(
				'label' => 'hapus',
				'options' => array(
					'rel' => 350, 
					'class' => 'delete'
				),
				'click' => 'dialogUpdate',
				'url' => 'Yii::app()->controller->createUrl("admindelete",array("id"=>$data->primaryKey))'),		
		),
		'template' => '{view}&nbsp;{update}&nbsp;{delete}&nbsp;',
	));
	/* array(
		'header'	=> 'Check',
		'value'		=> 'CHtml::checkBox("deleteVacancy[]", false, array("value" => "$data->id", "id" => "deleteVacancy".$data->id, "class" => "check-for-delete"))',
		'type'		=> 'raw',
		'htmlOptions'	=> array('style' => 'width: 30px;', 'class'	=> 'center')
	)); */
	$this->widget('application.components.system.SGridView', array(
		'id'=>'ccn-employer-vacancy-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
		'columns' => $columnData,
		'pager' => array('header' => ''),
	));
?>
<?php //end.Grid Item ?>
