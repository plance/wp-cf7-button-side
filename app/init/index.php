<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * InIt user
 */
class WpCf7BtnSide_INIT_Index
{
	/**
	* Create
	*/
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		add_action('wp_footer', array($this, 'wp_footer'));
	}

	public function wp_enqueue_scripts()
	{
		$options = WpCf7BtnSide_DB::options();
		
		if(!empty($options['url_css']))
		{
			wp_enqueue_style('cf7-btn-side-bs', $options['url_css']);
		}
		if(!empty($options['url_js']))
		{
			wp_enqueue_script('cf7-btn-side-bs', $options['url_js'], array('jquery'), null, true);
		}

		if(!empty($options['use_plugin_css']))
		{
			wp_enqueue_style('cf7-btn-side', WpCf7BtnSide_INIT::$glob['url'].'assets/index/style.css');
		}	
	}

	public function wp_footer()
	{
		$options = WpCf7BtnSide_DB::options();
		?>
		<div class="cf7-btn-side-block cf7-btn-side-block--<?php echo $options['button_position'] ?>">
			<?php if($options['button_type'] == 'text'): ?>
				<div class="cf7-btn-side-button-wrap cf7-btn-side-button-wrap--<?php echo $options['button_position'] ?>">
					<button type="button" class="<?php echo $options['button_class'] ?> cf7-btn-side-button" data-toggle="modal" data-target="#cf7-modal">
						<?php echo $options['button_label'] ?>
					</button>
				</div>
			<?php elseif($options['button_type'] == 'image'): ?>
				<div class="cf7-btn-side-img-wrap">
					<img src="<?php echo $options['button_img_url'] ?>" class="cf7-btn-side-img" data-toggle="modal" data-target="#cf7-modal">
				</div>
			<?php endif; ?>
		</div>

		<div class="modal" id="cf7-modal">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<h4 class="modal-title"><?php echo $options['modal_title'] ?></h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<?php echo do_shortcode('[contact-form-7 id="'.$options['cf7_id'].'"]') ?>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}