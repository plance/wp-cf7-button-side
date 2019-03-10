<?php defined('ABSPATH') or die('No script kiddies please!'); ?>

<div class="wrap">
	<h1><?php echo __('Configure', 'lance') ?></h1>
	<form method="post">
		<?php wp_nonce_field('wp-cf7-button-side-xyz'); ?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('button_position') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldSelect('button_position', array(
						'right-top' => __('Right top', 'lance'),
						'right-middle' => __('Right middle', 'lance'),
						'right-bottom' => __('Right bottom', 'lance'),
						'left-top' => __('Left top', 'lance'),
						'left-middle' => __('Left middle', 'lance'),
						'left-bottom' => __('Left bottom', 'lance'),
					), $Validate -> getData('button_position')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('button_type') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldSelect('button_type', array(
						'text' => __('Text', 'lance'),
						'image' => __('Image', 'lance'),
					), $Validate -> getData('button_type')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('button_class') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('button_class', $Validate -> getData('button_class')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('button_label') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('button_label', $Validate -> getData('button_label')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('button_img_url') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('button_img_url', $Validate -> getData('button_img_url')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('modal_title') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('modal_title', $Validate -> getData('modal_title')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('cf7_id') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldSelect('cf7_id', $cf7_ids_ar, $Validate -> getData('cf7_id')) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('use_plugin_css') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldSelect('use_plugin_css', array(
						1 => __('Yes', 'lance'),
						0 => __('No', 'lance'),
					), $Validate -> getData('use_plugin_css')) ?>
					<small class="howto">
						<?php echo __('Plugin file', 'lance') ?>: <a href="<?php echo WpCf7BtnSide_INIT::$glob['url'] ?>assets/index/style.css" target="_blank"><?php echo WpCf7BtnSide_INIT::$glob['url'] ?>assets/index/style.css</a>
					</small>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('url_css') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('url_css', $Validate -> getData('url_css'), array('style' => 'width: 90%')) ?><br>
					<small class="howto"><?php echo __('If your theme does not use Bootstrap 4, insert here link to the CSS of Bootstrap (only modal needed)', 'lance') ?></small>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $Validate -> getLabel('url_js') ?></th>
				<td>
					<?php echo WpCf7BtnSideCore_Helper_Html::fieldInput('url_js', $Validate -> getData('url_js'), array('style' => 'width: 90%')) ?>
					<small class="howto"><?php echo __('If your theme does not use Bootstrap 4, insert here link to the JavaScript of Bootstrap (only modal needed)', 'lance') ?></small>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>