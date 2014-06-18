<?php 
//echo var_dump($values);
echo print_r($values[0]);
echo  '<br/>';
foreach ($values as $key => $val): 
print_r($key);
echo  '<br/>';
print_r($val);
echo  '<br/>';
//foreach ($values as $key => $val): 
?>
    <div class="control-group">
        <?php echo CHtml::label($model->getAttributesLabels($key), $key); ?>
        <?php 
        if($key === 'ssl')
            echo CHtml::checkBox(get_class($model) . '[' . $category . '][' . $key . ']', $val); 
        else 
            echo CHtml::textField(get_class($model) . '[' . $category . '][' . $key . ']', $val, array('class'=>'input-xxlarge')); 
 
        ?>
        <?php echo CHtml::error($model, $category); ?>
    </div>
<?php endforeach; ?>