<?php

$this->breadcrumbs = array(
	CompanyStructure::label(2),
	'Index',
);

//$this->mainT = 'AD';
//$this->subT = 'CS';


?>


<?php $this->beginWidget('yiiwheels.widgets.box.WhBox',
	array(
		'title' => GxHtml::encode(CompanyStructure::label(2)),
		'headerButtons' => array(
			TbHtml::buttonGroup(
				array(
					array('label' => 'Create', 'icon' => TbHtml::ICON_PLUS),
					array('label' => 'List', 'icon' => TbHtml::ICON_LIST, 'class' => 'active'),
					array('label' => 'Manage', 'icon' => TbHtml::ICON_WRENCH),
				), array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO, 'color' => TbHtml::BUTTON_COLOR_PRIMARY)
			),
			'&nbsp;',
			TbHtml::buttonDropdown(
				'More',
				array(
					array('label' => 'Update', 'url' => '#', 'icon' => TbHtml::ICON_EDIT),
					array('label' => 'Delete', 'url' => '#', 'icon' => TbHtml::ICON_TRASH),
					array('label' => 'Export', 'url' => '#', 'icon' => TbHtml::ICON_DOWNLOAD_ALT),
				)
			),
			
		)
	));?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
<?php $this->endWidget();?>