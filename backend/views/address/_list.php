<?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'address-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		array(
				'name'=>'user_id',
				'value'=>'GxHtml::valueEx($data->user)',
				'filter'=>GxHtml::listDataEx(Users::model()->findAllAttributes(null, true)),
				),
		'firstname',
		'lastname',
		'company',
		'tax_id',
		/*
		'address_1',
		'address_2',
		'city',
		'postal_code',
		array(
				'name'=>'country_id',
				'value'=>'GxHtml::valueEx($data->country)',
				'filter'=>GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'zone_id',
				'value'=>'GxHtml::valueEx($data->zone)',
				'filter'=>GxHtml::listDataEx(Zone::model()->findAllAttributes(null, true)),
				),
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
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
			'template' => '{view}{update}{delete}',
		),
	),
)); ?>