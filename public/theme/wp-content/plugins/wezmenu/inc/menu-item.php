<?php
add_action( 'admin_footer-nav-menus.php' , 'wezmenu_menu_item_config_panel_render');
function wezmenu_menu_item_config_panel_render() {
	global $wezmenu_item_settings;
	$icons = array('american-sign-language-interpreting','asl-interpreting','assistive-listening-systems','audio-description','blind','braille','deaf','deafness','envira','gitlab','glide','glide-g','hard-of-hearing','low-vision','question-circle-o','sign-language','signing','snapchat','snapchat-ghost','snapchat-square','universal-access','viadeo','viadeo-square','volume-control-phone','wheelchair-alt','wpbeginner','wpforms','adjust','american-sign-language-interpreting','anchor','archive','area-chart','arrows','arrows-h','arrows-v','asl-interpreting','assistive-listening-systems','asterisk','at','audio-description','automobile','balance-scale','ban','bank','bar-chart','bar-chart-o','barcode','bars','battery-0','battery-1','battery-2','battery-3','battery-4','battery-empty','battery-full','battery-half','battery-quarter','battery-three-quarters','bed','beer','bell','bell-o','bell-slash','bell-slash-o','bicycle','binoculars','birthday-cake','blind','bluetooth','bluetooth-b','bolt','bomb','book','bookmark','bookmark-o','braille','briefcase','bug','building','building-o','bullhorn','bullseye','bus','cab','calculator','calendar','calendar-check-o','calendar-minus-o','calendar-o','calendar-plus-o','calendar-times-o','camera','camera-retro','car','caret-square-o-down','caret-square-o-left','caret-square-o-right','caret-square-o-up','cart-arrow-down','cart-plus','cc','certificate','check','check-circle','check-circle-o','check-square','check-square-o','child','circle','circle-o','circle-o-notch','circle-thin','clock-o','clone','close','cloud','cloud-download','cloud-upload','code','code-fork','coffee','cog','cogs','comment','comment-o','commenting','commenting-o','comments','comments-o','compass','copyright','creative-commons','credit-card','credit-card-alt','crop','crosshairs','cube','cubes','cutlery','dashboard','database','deaf','deafness','desktop','diamond','dot-circle-o','download','edit','ellipsis-h','ellipsis-v','envelope','envelope-o','envelope-square','eraser','exchange','exclamation','exclamation-circle','exclamation-triangle','external-link','external-link-square','eye','eye-slash','eyedropper','fax','feed','female','fighter-jet','file-archive-o','file-audio-o','file-code-o','file-excel-o','file-image-o','file-movie-o','file-pdf-o','file-photo-o','file-picture-o','file-powerpoint-o','file-sound-o','file-video-o','file-word-o','file-zip-o','film','filter','fire','fire-extinguisher','flag','flag-checkered','flag-o','flash','flask','folder','folder-o','folder-open','folder-open-o','frown-o','futbol-o','gamepad','gavel','gear','gears','gift','glass','globe','graduation-cap','group','hand-grab-o','hand-lizard-o','hand-paper-o','hand-peace-o','hand-pointer-o','hand-rock-o','hand-scissors-o','hand-spock-o','hand-stop-o','hard-of-hearing','hashtag','hdd-o','headphones','heart','heart-o','heartbeat','history','home','hotel','hourglass','hourglass-1','hourglass-2','hourglass-3','hourglass-end','hourglass-half','hourglass-o','hourglass-start','i-cursor','image','inbox','industry','info','info-circle','institution','key','keyboard-o','language','laptop','leaf','legal','lemon-o','level-down','level-up','life-bouy','life-buoy','life-ring','life-saver','lightbulb-o','line-chart','location-arrow','lock','low-vision','magic','magnet','mail-forward','mail-reply','mail-reply-all','male','map','map-marker','map-o','map-pin','map-signs','meh-o','microphone','microphone-slash','minus','minus-circle','minus-square','minus-square-o','mobile','mobile-phone','money','moon-o','mortar-board','motorcycle','mouse-pointer','music','navicon','newspaper-o','object-group','object-ungroup','paint-brush','paper-plane','paper-plane-o','paw','pencil','pencil-square','pencil-square-o','percent','phone','phone-square','photo','picture-o','pie-chart','plane','plug','plus','plus-circle','plus-square','plus-square-o','power-off','print','puzzle-piece','qrcode','question','question-circle','question-circle-o','quote-left','quote-right','random','recycle','refresh','registered','remove','reorder','reply','reply-all','retweet','road','rocket','rss','rss-square','search','search-minus','search-plus','send','send-o','server','share','share-alt','share-alt-square','share-square','share-square-o','shield','ship','shopping-bag','shopping-basket','shopping-cart','sign-in','sign-language','sign-out','signal','signing','sitemap','sliders','smile-o','soccer-ball-o','sort','sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-asc','sort-desc','sort-down','sort-numeric-asc','sort-numeric-desc','sort-up','space-shuttle','spinner','spoon','square','square-o','star','star-half','star-half-empty','star-half-full','star-half-o','star-o','sticky-note','sticky-note-o','street-view','suitcase','sun-o','support','tablet','tachometer','tag','tags','tasks','taxi','television','terminal','thumb-tack','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ticket','times','times-circle','times-circle-o','tint','toggle-down','toggle-left','toggle-off','toggle-on','toggle-right','toggle-up','trademark','trash','trash-o','tree','trophy','truck','tty','tv','umbrella','universal-access','university','unlock','unlock-alt','unsorted','upload','user','user-plus','user-secret','user-times','users','video-camera','volume-control-phone','volume-down','volume-off','volume-up','warning','wheelchair','wheelchair-alt','wifi','wrench','american-sign-language-interpreting','asl-interpreting','assistive-listening-systems','audio-description','blind','braille','cc','deaf','deafness','hard-of-hearing','low-vision','question-circle-o','sign-language','signing','tty','universal-access','volume-control-phone','wheelchair','wheelchair-alt','hand-grab-o','hand-lizard-o','hand-o-down','hand-o-left','hand-o-right','hand-o-up','hand-paper-o','hand-peace-o','hand-pointer-o','hand-rock-o','hand-scissors-o','hand-spock-o','hand-stop-o','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ambulance','automobile','bicycle','bus','cab','car','fighter-jet','motorcycle','plane','rocket','ship','space-shuttle','subway','taxi','train','truck','wheelchair','genderless','intersex','mars','mars-double','mars-stroke','mars-stroke-h','mars-stroke-v','mercury','neuter','transgender','transgender-alt','venus','venus-double','venus-mars','file','file-archive-o','file-audio-o','file-code-o','file-excel-o','file-image-o','file-movie-o','file-o','file-pdf-o','file-photo-o','file-picture-o','file-powerpoint-o','file-sound-o','file-text','file-text-o','file-video-o','file-word-o','file-zip-o','circle-o-notch','cog','gear','refresh','spinner','check-square','check-square-o','circle','circle-o','dot-circle-o','minus-square','minus-square-o','plus-square','plus-square-o','square','square-o','cc-amex','cc-diners-club','cc-discover','cc-jcb','cc-mastercard','cc-paypal','cc-stripe','cc-visa','credit-card','credit-card-alt','google-wallet','paypal','area-chart','bar-chart','bar-chart-o','line-chart','pie-chart','bitcoin','btc','cny','dollar','eur','euro','gbp','gg','gg-circle','ils','inr','jpy','krw','money','rmb','rouble','rub','ruble','rupee','shekel','sheqel','try','turkish-lira','usd','won','yen','align-center','align-justify','align-left','align-right','bold','chain','chain-broken','clipboard','columns','copy','cut','dedent','eraser','file','file-o','file-text','file-text-o','files-o','floppy-o','font','header','indent','italic','link','list','list-alt','list-ol','list-ul','outdent','paperclip','paragraph','paste','repeat','rotate-left','rotate-right','save','scissors','strikethrough','subscript','superscript','table','text-height','text-width','th','th-large','th-list','underline','undo','unlink','angle-double-down','angle-double-left','angle-double-right','angle-double-up','angle-down','angle-left','angle-right','angle-up','arrow-circle-down','arrow-circle-left','arrow-circle-o-down','arrow-circle-o-left','arrow-circle-o-right','arrow-circle-o-up','arrow-circle-right','arrow-circle-up','arrow-down','arrow-left','arrow-right','arrow-up','arrows','arrows-alt','arrows-h','arrows-v','caret-down','caret-left','caret-right','caret-square-o-down','caret-square-o-left','caret-square-o-right','caret-square-o-up','caret-up','chevron-circle-down','chevron-circle-left','chevron-circle-right','chevron-circle-up','chevron-down','chevron-left','chevron-right','chevron-up','exchange','hand-o-down','hand-o-left','hand-o-right','hand-o-up','long-arrow-down','long-arrow-left','long-arrow-right','long-arrow-up','toggle-down','toggle-left','toggle-right','toggle-up','arrows-alt','backward','compress','eject','expand','fast-backward','fast-forward','forward','pause','pause-circle','pause-circle-o','play','play-circle','play-circle-o','random','step-backward','step-forward','stop','stop-circle','stop-circle-o','youtube-play','500px','adn','amazon','android','angellist','apple','behance','behance-square','bitbucket','bitbucket-square','bitcoin','black-tie','bluetooth','bluetooth-b','btc','buysellads','cc-amex','cc-diners-club','cc-discover','cc-jcb','cc-mastercard','cc-paypal','cc-stripe','cc-visa','chrome','codepen','codiepie','connectdevelop','contao','css3','dashcube','delicious','deviantart','digg','dribbble','dropbox','drupal','edge','empire','envira','expeditedssl','facebook','facebook-f','facebook-official','facebook-square','firefox','flickr','fonticons','fort-awesome','forumbee','foursquare','ge','get-pocket','gg','gg-circle','git','git-square','github','github-alt','github-square','gitlab','gittip','glide','glide-g','google','google-plus','google-plus-square','google-wallet','gratipay','hacker-news','houzz','html5','instagram','internet-explorer','ioxhost','joomla','jsfiddle','lastfm','lastfm-square','leanpub','linkedin','linkedin-square','linux','maxcdn','meanpath','medium','mixcloud','modx','odnoklassniki','odnoklassniki-square','opencart','openid','opera','optin-monster','pagelines','paypal','pied-piper','pied-piper-alt','pinterest','pinterest-p','pinterest-square','product-hunt','qq','ra','rebel','reddit','reddit-alien','reddit-square','renren','safari','scribd','sellsy','share-alt','share-alt-square','shirtsinbulk','simplybuilt','skyatlas','skype','slack','slideshare','snapchat','snapchat-ghost','snapchat-square','soundcloud','spotify','stack-exchange','stack-overflow','steam','steam-square','stumbleupon','stumbleupon-circle','tencent-weibo','trello','tripadvisor','tumblr','tumblr-square','twitch','twitter','twitter-square','usb','viacoin','viadeo','viadeo-square','vimeo','vimeo-square','vine','vk','wechat','weibo','weixin','whatsapp','wikipedia-w','windows','wordpress','wpbeginner','wpforms','xing','xing-square','y-combinator','y-combinator-square','yahoo','yc','yc-square','yelp','youtube','youtube-play','youtube-square','ambulance','h-square','heart','heart-o','heartbeat','hospital-o','medkit','plus-square','stethoscope','user-md','wheelchair');
	?>
	<div class="wezmenu-config-panel-wrapper">
		<div class="wezmenu-header">
			<h2>
				<i class="fa fa-cogs"></i><span>Menu Name</span>
				<button class="wez-button wezmenu-config-panel-save" type="button"><i class="fa fa-save"></i> <?php echo __('Save Changes','wezmenu') ?></button>
				<button class="wez-button wezmenu-config-panel-close" type="button"><i class="fa fa-close"></i></button>
			</h2>
		</div>
		<div class="wezmenu-config-panel-left">
			<ul>
				<?php foreach ($wezmenu_item_settings as $item_key => $item_value): ?>
				<li <?php echo ($item_key == 'general' ? 'class="active"' :'') ?> rel-section="<?php echo esc_attr('section-' . $item_key) ?>"><i class="fa <?php echo esc_attr($item_value['icon']) ?>"></i><span><?php echo esc_html($item_value['text']) ?></span></li>
				<?php endforeach; ?>
				<li class="wez-reset">
					<i class="fa fa-refresh"></i> <?php _e('Reset','wezmenu') ?>
				</li>
			</ul>
		</div>
		<form class="wezmenu-config-panel-right">
			<div class="wezmenu-config-panel-right-inner">
				<?php foreach ($wezmenu_item_settings as $item_key => $item_value): ?>
					<section <?php echo ($item_key == 'general' ? 'class="active"' :'') ?> id="<?php echo esc_attr('section-' . $item_key) ?>">
						<?php foreach ($item_value['config'] as $config_key => $config): ?>
							<?php wezmenu_menu_item_config_panel_render_item($config_key, $config);?>
						<?php endforeach; ?>
					</section>
				<?php endforeach; ?>
			</div>
			<div class="wezmenu-panel-scroll-wrapper">
				<div class="wezmenu-panel-scroll">
					<div class="wezmenu-panel-drag"></div>
				</div>
			</div>
		</form>
		<div class="wezmenu-icon-popup">
			<div class="wezmenu-icon-popup-header">
				<input type="text" placeholder="<?php _e('Type to search...','wezmenu') ?>"/>
				<div class="wezmenu-icon-remove">
					<button class="wez-button">Remove Icon</button>
				</div>
				<i class="fa fa-remove"></i>
			</div>
			<div class="wezmenu-icon-popup-content">
				<ul>
					<?php foreach($icons as $icon_value): ?>
						<li title="<?php echo esc_attr($icon_value) ?>"><i class="fa fa-<?php echo esc_attr($icon_value) ?>"></i></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<?php
}
function wezmenu_menu_item_config_panel_render_item($config_key, $config) {
	switch($config['type']) {
		case 'heading':
			?>
				<h3 class="wez-section-title"><?php echo esc_html($config['text']); ?></h3>
			<?php
			break;
		case 'checkbox':
			$chekbox_value = '1';
			if (isset($config['value']) && !empty($config['value'])) {
				$chekbox_value = $config['value'];
			}
			?>
			<div class="wez-col">
				<label class="wez-position-relative" for="wezmenu_config_<?php echo esc_attr($config_key); ?>"><input class="wez-input wez-checkbox" name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" type="checkbox" value="<?php echo esc_attr($chekbox_value) ?>" <?php checked( $config['std'], $chekbox_value ); ?>/> <span><?php echo esc_html($config['text']); ?></span> </label>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'text':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input"><input name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-textbox" type="text" value="<?php echo esc_attr($config['std']); ?>"/></div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'array':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input"><input name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-textbox wez-array" type="text" value="<?php echo esc_attr($config['std']); ?>"/></div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'select':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input">
					<label class="wez-input-label" for="wezmenu_config_<?php echo esc_attr($config_key); ?>">
						<select name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-select">
							<?php foreach ($config['options'] as $key => $value):?>
								<option <?php selected( $config['std'], $key ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value) ?></option>
							<?php endforeach;?>
						</select>
						<div class="wez-select-arrow"><i class="fa fa-caret-down"></i></div>
					</label>
				</div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'textarea':
			$element_style = '';
			if (isset($config['height']) && $config['height']) {
				$element_style = 'height:' . $config['height'];
			}
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input"><textarea name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-textarea" style="<?php echo esc_attr($element_style) ?>"><?php echo esc_html($config['std']); ?></textarea></div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'select-group':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input">
					<label class="wez-input-label" for="wezmenu_config_<?php echo esc_attr($config_key); ?>">
						<select name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-select wez-select-group">
							<?php foreach ($config['options'] as $op_key => $op_value):?>
								<optgroup label="<?php echo esc_attr($op_value['text']) ?>">
									<?php foreach ($op_value['options'] as $key => $value):?>
										<option <?php selected( $config['std'], $key ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value) ?></option>
									<?php endforeach;?>
								</optgroup>
							<?php endforeach;?>
						</select>
						<div class="wez-select-arrow"><i class="fa fa-caret-down"></i></div>
					</label>
				</div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'image':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input wez-col-media-image">
					<input name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-textbox wez-media-image" type="text" value="<?php echo esc_attr($config['std']); ?>"/>
					<button type="button" id="browser_wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-button wez-media-button"><i class="fa fa-image"></i></button>
				</div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'icon':
			?>
			<div class="wez-col">
				<div class="wez-col-input">
					<div class="wez-icon-wrapper" data-rel="wezmenu_config_<?php echo esc_attr($config_key); ?>">
						<input name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-textbox wez-icon" type="hidden" value="<?php echo esc_attr($config['std']); ?>"/>
						<i></i>
						<span><?php echo esc_html($config['text']); ?></span>
						<div class="wez-icon-remove"><i class="fa fa-remove"></i></div>
					</div>
				</div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
		case 'color':
			?>
			<div class="wez-col">
				<div class="wez-col-title"><?php echo esc_html($config['text']); ?></div>
				<div class="wez-col-input">
					<input name="<?php echo esc_attr($config_key); ?>" id="wezmenu_config_<?php echo esc_attr($config_key); ?>" class="wez-input wez-color-picker" type="text" value="<?php echo esc_attr($config['std']); ?>"/>
				</div>
				<?php wezmenu_menu_item_render_description($config); ?>
			</div>
			<?php
			break;
	}
}
function wezmenu_menu_item_render_description($config) {
	?>
	<?php if (isset($config['des']) && (!empty($config['des']))):?>
		<div class="wez-description"><?php echo wp_kses_post($config['des']); ?></div>
	<?php endif;?>
	<?php
}

function wezmenu_save_config_callback() {
	$error_result = array(
		'code' => '-1',
		'message' => __('Save menu config fail','wezmenu'),
	);

	$config = $_POST['config'];
	$menu_id = $_POST['id'];

	$term = wp_get_object_terms($menu_id, 'nav_menu');
	if (!$term) {
		echo json_encode($error_result);
		die();
	}
	$term = $term[0];

	$menu_list = wp_get_nav_menu_items( $term->term_id, array( 'post_status' => 'any' ) );
	$menu_obj = null;
	foreach ($menu_list as $key => $menu_value) {
		if ($menu_value->ID == $menu_id) {
			$menu_obj = $menu_list[$key];
			break;
		}
	}
	if (!$menu_obj) {
		echo json_encode($error_result);
		die();
	}

	$args = array(
		'menu-item-db-id' => $menu_id,
		'menu-item-object-id' => $menu_obj->object_id,
		'menu-item-object' => $menu_obj->object,
		'menu-item-parent-id' => $menu_obj->menu_item_parent,
		'menu-item-position' => $menu_obj->menu_order,
		'menu-item-type' => $menu_obj->type,
		'menu-item-title' => $config['general-title'],
		'menu-item-url' => $menu_obj->type == 'custom' ? $config['general-url'] : $menu_obj->url,
		'menu-item-description' => $config['general-description'],
		'menu-item-attr-title' => $config['general-attr-title'],
		'menu-item-target' => $config['general-target'],
		'menu-item-classes' => $config['general-classes'],
		'menu-item-xfn' => $config['general-xfn'],
		'menu-item-status' => $menu_obj->post_status,
	);

	$id = wp_update_nav_menu_item( $term->term_id, $menu_id, $args );
	if ( $id && ! is_wp_error( $id ) ) {
		foreach($config as $key => $value) {
			if ((strpos($key, 'nosave-') === 0) || (strpos($key, 'general-') === 0)) {
				unset($config[$key]);
			}
		}

		update_post_meta( (int) $menu_id, '_menu_item_wezmenu_config', maybe_unserialize( $config ) );

		if (isset($config['widget-area']) && !empty($config['widget-area'])) {
			$widgets = get_option(WEZMENU_MENU_ITEM_WIDGET_AREAS, array());
			$widgets[$menu_obj->post_name] = $config['widget-area'];
			update_option(WEZMENU_MENU_ITEM_WIDGET_AREAS, $widgets);
		}
		echo json_encode(array(
			'code' => '1',
			'message' => '',
		));
		die();
	}
	echo json_encode($error_result);
	die();
}
add_action( 'wp_ajax_wezmenu_save_config', 'wezmenu_save_config_callback' );