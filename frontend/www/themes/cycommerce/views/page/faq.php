<div class="section_head_general">FAQs</div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php
	if(!empty($faqs)){ ?>
	<div id="accordion2" class="accordion">
	<?php foreach($faqs as $i=>$faq){ ?>
		<div class="accordion-group">
		  <div class="accordion-heading">
			<a href="#collapse_<?php echo $i; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">
			  <?php echo $faq->title; ?>
			</a>
		  </div>
		  <div class="accordion-body collapse" id="collapse_<?php echo $i; ?>">
			<div class="accordion-inner">
				<?php echo $faq->description; ?>
			</div>
		  </div>
		</div>		
	<?php } ?>
	</div>
	<?php } ?>
</div>
</div>
