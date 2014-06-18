
<?php $this->beginWidget('yiiwheels.widgets.box.WhBox',
	array(
		'title' => TbHtml::encode('Staffs'),
		'headerButtons' => array(
			TbHtml::buttonGroup(
				array(
					array('label' => 'Create', 'url' => $this->createUrl('create'), 'icon' => TbHtml::ICON_PLUS, 'class' => 'ylink create'),
					array('label' => 'List', 'url' => $this->createUrl('index'), 'icon' => TbHtml::ICON_LIST, 'class' => 'active ylink list'),
					array('label' => 'Manage', 'url' => $this->createUrl('admin'), 'icon' => TbHtml::ICON_WRENCH, 'class' => 'ylink manage'),
				), array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO, 'color' => TbHtml::BUTTON_COLOR_PRIMARY)
			),
			'&nbsp;',
			TbHtml::buttonDropdown(
				'Export',
				array(
					array('label' => 'Selected', 'url' => $this->createUrl('exportselected'), 'class' => 'exportSelected'),
					array('label' => 'All', 'url' => $this->createUrl('exportall'), 'class' => 'exportAll'),
				), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'icon' => TbHtml::ICON_DOWNLOAD_ALT, 'class' => 'exportDrop')
			),
			TbHtml::linkbutton('View', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'url' => $this->createUrl('view'), 'icon' => TbHtml::ICON_EYE_OPEN, 'class' => 'viewDrop hide')),
			TbHtml::linkbutton('Edit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'url' => $this->createUrl('update'), 'icon' => TbHtml::ICON_EDIT, 'class' => 'updateDrop hide')),
			'&nbsp;',
			TbHtml::linkbutton('Delete', array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url' => $this->createUrl('batchdelete'), 'icon' => TbHtml::ICON_TRASH, 'class' => 'deleteSelected')),
			TbHtml::linkbutton('Delete', array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url' => $this->createUrl('delete'), 'icon' => TbHtml::ICON_TRASH, 'class' => 'delete hide')),
			'&nbsp;',
		)
	)); ?>
<div id="aMessage"></div>

<div id="viewContent">
	<?php $this->renderPartial('_list', array('dataProvider' => $dataProvider)); ?>
</div>
<div id="errorText" class="hide"><?php echo Yii::t('info','An error has occurred'); ?></div>
<div class="errorTextSort hide"><?php echo Yii::t('info','An error has occurred during sorting'); ?></div>
<?php $this->endWidget();?>