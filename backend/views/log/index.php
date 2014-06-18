<?php
/* @var $this LogController */
/* @var $dataProvider CArrayDataProvider */

$this->breadcrumbs=array(
	'Logs',
);

?>

<h1>Logs</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array(
                'name'=>'Name',
                'value'=>'$data["name"]',
                ),
                array(
                'name'=>'Size (bytes)',
                'value'=>'$data["size"]',
                ),
                array(
                'name'=>'Download',
				'type'=>'raw',
				'value' => 'CHtml::link(CHtml::encode("txt"),array("log/download","fname"=>$data["name"]))." ".CHtml::link(CHtml::encode("zip"),array("log/download","zip"=>"yes","fname"=>$data["name"]))',
                ),
        ),
)); ?>
