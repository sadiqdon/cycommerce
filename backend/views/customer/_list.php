<?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'customer-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'username',
		'email',
		array(
			'name' => 'superuser',
			'value' => '($data->superuser == 0) ? \'No\' : \'Yes\'',
			'filter' => array('0' => 'No', '1' => 'Yes'),
		),		
		array(
			'name' => 'status',
			'value' => '($data->status == 0) ? \'No\' : \'Yes\'',
			'filter' => array('0' => 'No', '1' => 'Yes'),
		),	
		'type',
		'create_at',
		'lastvisit_at',
		/*
		'password_update_time',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 50px'),
			'buttons' => array(
						 'delete' => array(
						 'label' => Yii::t('label', 'Delete'), // text label of the button
						  'options' => array("class" => "del vlink", 'title' => Yii::t('label', 'Delete')),
						  ),
						 'update' => array(
						 'label' => Yii::t('label', 'Update'), // text label of the button
						 'options' => array("class" => "update vlink", 'title' => Yii::t('label', 'Update')), 
							),
						 'view' => array(
						  'label' => Yii::t('label', 'View'), // text label of the button
						  'options' => array("class" => "view vlink", 'title' => Yii::t('label', 'View')), 
							)
						),
			'template' => '{view} {update} {delete}',
		),
	),
)); ?>