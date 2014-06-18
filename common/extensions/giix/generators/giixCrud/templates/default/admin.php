<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n
\$this->breadcrumbs = array(
	\$model->label(2) => array('index'),
	'Manage',
);\n";
?>

$this->menu = array(
		array('label'=>'List' . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>'Create' . ' ' . $model->label(), 'url'=>array('create')),
	);

?>

<h1><?php echo '<?php'; ?> echo 'Manage' . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<?php echo "<?php \$this->renderPartial('_manage', array(
	'model' => \$model,
)); ?>\n"; ?>