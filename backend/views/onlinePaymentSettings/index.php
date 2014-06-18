<h3>Online Payment Settings</h3>
 
<?php echo CHtml::errorSummary($model); ?>
<?php
echo CHtml::beginForm();
?>
<ul class="nav nav-tabs" id="site-settings">
<?php
 
$tabs = array();
$i = 0;
    foreach ($model->attributes as $category => $values){?>
	<?php print_r($values); echo $values[0]['Global_PaySettings'] ; foreach($values as $key => $value){?>
        <li<?php echo !$i?' class="active"':''?>><a href="#<?php echo $key?>" data-toggle="tab"><?php echo ucfirst($key)?></a></li>
    <?php 
	}
    $i ++;
    }?>
</ul>
    <div class="tab-content">
        <?php 
        $i = 0;
        foreach ($model->attributes as $category => $values):?>
		<?php print_r($values); ?>
            <div class="tab-pane<?php echo !$i?' active':''?>" id="<?php echo $category?>">
                <?php
                $this->renderPartial(
                        /*'_'.$category, */
						'_category',
                        array('model' => $model, 'values' => $values, 'category' => $category)
                    );
                ?>
            </div>
        <?php 
        $i ++;
        endforeach;?>
    </div>
<?php
echo CHtml::submitButton('Submit', array('class' => 'btn'));
echo CHtml::endForm();