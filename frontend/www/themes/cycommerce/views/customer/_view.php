<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>
<?php 

	$tabs = array(array('label' => 'General', 'active' => true, 'content' => 
		$this->renderPartial('_view_detail', array('model'=>$model,'profile'=>$profile), true, true)
	));
	if(isset($address)){
		foreach($address as $i=>$add){
			$tabs[] = array('label' => 'Address '.($i+1), 'content' => 
				$this->renderPartial('_view_address', array('model'=>$add), true, false),
			);
		}
	}
	echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); 
?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>