<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "<?php\n
\$this->breadcrumbs = array(
	'$label' => array('index'),
	'Manage',
);\n";
?>

$this->menu = array(
		array('label'=>Yii::t('label','List').' <?php echo $this->modelClass; ?>', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' <?php echo $this->modelClass; ?>', 'url'=>array('create')),
	);

?>

<h1><?php echo "<?php Yii::t('label','Manage'); ?>"?> <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<?php echo "<?php echo \$this->renderPartial('_manage', array('model'=>\$model)); ?>"; ?>