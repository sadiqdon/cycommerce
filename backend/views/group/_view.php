<div class="view">

	<?php 
	$pgroups = Group::model()->with('branches')->findByPk($data->id);
	$gvalue = '';
	foreach($pgroups->branches as $group){
		$gvalue .= $group->name.', ';
	}
	if(!empty($gvalue)){
		$gvalue = substr($gvalue, 0, strlen($gvalue)-2);
	}
	?>

	<?php $this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$data,
		'attributes'=>array(
			'id',
			'name',
			array(
				'label' => 'Branch(es)',
				'name' => 'branches',
				'value' => $gvalue,
			),
			);
	));
	?>
</div>