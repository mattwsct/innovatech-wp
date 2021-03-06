<?php

/**
 * Outputs language switcher.
 *
 * Uses customization options from Shortcode language switcher.
 */
function trp_the_language_switcher(){
    $trp = TRP_Translate_Press::get_trp_instance();
    $language_switcher = $trp->get_component( 'language_switcher' );
    echo $language_switcher->language_switcher();
}

/**
 * Wrapper function for json_encode to eliminate possible UTF8 special character errors
 * @param $value
 * @return mixed|string|void
 */
function trp_safe_json_encode($value){
    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
        $encoded = json_encode($value, JSON_PRETTY_PRINT);
    } else {
        $encoded = json_encode($value);
    }
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            return $encoded;
        case JSON_ERROR_DEPTH:
            return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_STATE_MISMATCH:
            return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_CTRL_CHAR:
            return 'Unexpected control character found';
        case JSON_ERROR_SYNTAX:
            return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_UTF8:
            $clean = trp_utf8ize($value);
            return trp_safe_json_encode($clean);
        default:
            return 'Unknown error'; // or trigger_error() or throw new Exception()

    }
}

/**
 * Helper function for trp_safe_json_encode that helps eliminate utf8 json encode errors
 * @param $mixed
 * @return array|string
 */
function trp_utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = trp_utf8ize($value);
        }
    } else if (is_string ($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}

/**
 * function that gets the translation for a string with context directly from a .mo file
 * @TODO this was developped firstly for woocommerce so it maybe needs further development.
*/
function trp_x( $text, $context, $domain, $language ){

    /* try to find the correct path for the textdomain */
    $path = trp_find_translation_location_for_domain( $domain, $language );

    if( !empty( $path ) ) {

        $mo_file = wp_cache_get( 'trp_x_' . $domain .'_'. $language );

        if( false === $mo_file ){
            $mo_file = new MO();
            $mo_file->import_from_file( $path );
            wp_cache_set( 'trp_x_' . $domain .'_'. $language, $mo_file );
        }

        if ( !$mo_file ) return $text;


        if (!empty($mo_file->entries[$context . '' . $text]))
            $text = $mo_file->entries[$context . '' . $text]->translations[0];
    }

    return $text;
}

/**
 * Function that tries to find the path for a translation file defined by textdomain and language
 * @param $domain the textdomain of the string that you want the translation for
 * @param $language the language in which you want the translation
 * @return string the path of the mo file if it is found else an empty string
 */
function trp_find_translation_location_for_domain( $domain, $language ){

    $path = '';

    if( file_exists( WP_LANG_DIR . '/plugins/'. $domain .'-' . $language . '.mo') ) {
        $path = WP_LANG_DIR . '/plugins/'. $domain .'-' . $language . '.mo';
    }
    elseif ( file_exists( WP_LANG_DIR . '/themes/'. $domain .'-' . $language . '.mo') ){
        $path = WP_LANG_DIR . '/themes/'. $domain .'-' . $language . '.mo';
    } elseif( $domain === '' && file_exists( WP_LANG_DIR . '/' . $language . '.mo')){
        $path = WP_LANG_DIR . '/' . $language . '.mo';
    } else {
        $possible_translation_folders = array( '', 'languages/', 'language/', 'translations/', 'translation/', 'lang/' );
        foreach( $possible_translation_folders as $possible_translation_folder ){
            if (file_exists(get_template_directory() . '/' . $possible_translation_folder . $domain . '-' . $language . '.mo')) {
                $path = get_template_directory() . '/' . $possible_translation_folder . $domain . '-' . $language . '.mo';
            } elseif ( file_exists(WP_PLUGIN_DIR . '/' . $domain . '/' . $possible_translation_folder . $domain . '-' . $language . '.mo') ) {
                $path = WP_PLUGIN_DIR . '/' . $domain . '/' . $possible_translation_folder . $domain . '-' . $language . '.mo';
            }
        }
    }

    return $path;
}

/**
 * Function that appends the affiliate_id to a given url
 * @param $link string the given url to append
 * @return string url with the added affiliate_id
 */
function trp_add_affiliate_id_to_link( $link ){

    //Avangate Affiliate Network
    $avg_affiliate_id = get_option('translatepress_avg_affiliate_id');
    if  ( !empty( $avg_affiliate_id ) ) {
        return esc_url( add_query_arg( 'avgref', $avg_affiliate_id, $link ) );
    }
    else{
        // AffiliateWP
        $affiliate_id = get_option('translatepress_affiliate_id');
        if  ( !empty( $affiliate_id ) ) {
            return esc_url( add_query_arg( 'ref', $affiliate_id, $link ) );
        }
    }

    return esc_url( $link );
}

/**
 * Function that makes string safe for display.
 *
 * Can be used on original or translated string.
 * Removes any unwanted html code from the string.
 * Do not confuse with trim.
 */
function trp_sanitize_string( $filtered ){
	$filtered = preg_replace( '/<script\b[^>]*>(.*?)<\/script>/is', '', $filtered );

	// don't remove \r \n \t. They are part of the translation, they give structure and context to the text.
	//$filtered = preg_replace( '/[\r\n\t ]+/', ' ', $filtered );
	$filtered = trim( $filtered );

	$found = false;
	while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
		$filtered = str_replace($match[0], '', $filtered);
		$found = true;
	}

	if ( $found ) {
		// Strip out the whitespace that may now exist after removing the octets.
		$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
	}

	return $filtered;
}

/**
 * Trim strings.
 *
 * @param string $string      Raw string.
 * @return string           Trimmed string.
 */
function trp_full_trim( $string ) {
	/* Make sure you update full_trim function from trp-ajax too*/

	/* Apparently the ??? char in the trim function turns some strings in an empty string so they can't be translated but I don't really know if we should remove it completely
	Removed chr( 194 ) . chr( 160 ) because it altered some special characters (????)
	Also removed \xA0 (the same as chr(160) for altering special characters */
	//$word = trim($word," \t\n\r\0\x0B\xA0???".chr( 194 ) . chr( 160 ) );

	/* Solution to replace the chr(194).chr(160) from trim function, in order to escape the whitespace character ( \xc2\xa0 ), an old bug that couldn't be replicated anymore. */
	/* Trim nbsp the same way as the whitespace (chr194 chr160) above */
	$prefixes = array( "\xc2\xa0", "&nbsp;" );
	do{
		$previous_iteration_string = $string;
		$string = trim($string, " \t\n\r\0\x0B");
		foreach( $prefixes as $prefix ) {
			$prefix_length = strlen($prefix);
			if (substr($string, 0, $prefix_length) == $prefix) {
				$string = substr($string, $prefix_length);
			}
			if (substr($string, -$prefix_length, $prefix_length) == $prefix) {
				$string = substr($string, 0, -$prefix_length);
			}
		}
	}while( $string != $previous_iteration_string );

	if ( strip_tags( $string ) == "" || trim ($string, " \t\n\r\0\x0B\xA0???.,/`~!@#\$?????%^&*():;-_=+[]{}\\|?/<>1234567890'\"" ) == '' ){
		$string = '';
	}

	return $string;
}

/**
 * function that checks if $_REQUEST['trp-edit-translation'] is set or if it has a certain value
 */
function trp_is_translation_editor( $value = '' ){
    if( isset( $_REQUEST['trp-edit-translation'] ) ){
        if( !empty( $value ) ) {
            if( $_REQUEST['trp-edit-translation'] === $value ) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $possible_values = array ('preview', 'true');
            if( in_array( $_REQUEST['trp-edit-translation'], $possible_values ) ) {
                return true;
            }
        }
    }

    return false;
}


/** Compatibility functions */

/**
 * Do not redirect when elementor preview is present
 *
 * @param $allow_redirect
 *
 * @return bool
 */
function trp_elementor_compatibility( $allow_redirect ){
	// compatibility with Elementor preview. Do not redirect to subdir language when elementor preview is present.
	if ( isset( $_GET['elementor-preview'] ) ) {
		return false;
	}
	return $allow_redirect;
}
add_filter( 'trp_allow_language_redirect', 'trp_elementor_compatibility' );


/**
 * Mb Strings missing PHP library error notice
 */
function trp_mbstrings_notification(){
	echo '<div class="notice notice-error"><p>' . __( '<strong>TranslatePress</strong> requires <strong><a href="http://php.net/manual/en/book.mbstring.php">Multibyte String PHP library</a></strong>. Please contact your server administrator to install it on your server.','translatepress-multilingual' ) . '</p></div>';
}

function trp_missing_mbstrings_library( $allow_to_run ){
	if ( ! extension_loaded('mbstring') ) {
		add_action( 'admin_menu', 'trp_mbstrings_notification' );
		return false;
	}
	return $allow_to_run;
}
add_filter( 'trp_allow_tp_to_run', 'trp_missing_mbstrings_library' );

/**
 * Don't have html inside menu title tags. Some themes just put in the title the content of the link without striping HTML
 */
add_filter( 'nav_menu_link_attributes', 'trp_remove_html_from_menu_title', 10, 3);
function trp_remove_html_from_menu_title( $atts, $item, $args ){
    $atts['title'] = wp_strip_all_tags($atts['title']);
    return $atts;
}

/**
 * Rework wp_trim_words so we can trim Chinese, Japanese and Thai words since they are based on characters as words.
 *
 * @since 1.3.0
 *
 * @param string $text      Text to trim.
 * @param int    $num_words Number of words. Default 55.
 * @param string $more      Optional. What to append if $text needs to be trimmed. Default '&hellip;'.
 * @return string Trimmed text.
 */
function trp_wp_trim_words( $text, $num_words = 55, $more = null, $original_text ) {
    if ( null === $more ) {
        $more = __( '&hellip;' );
    }
    // what we receive is the short text in the filter
    $text = $original_text;
    $text = wp_strip_all_tags( $text );

    $trp = TRP_Translate_Press::get_trp_instance();
    $trp_settings = $trp->get_component( 'settings' );
    $settings = $trp_settings->get_settings();

    $default_language= $settings["default-language"];

    $char_is_word = false;
    foreach (array('ch', 'ja', 'tw') as $lang){
        if (strpos($default_language, $lang) !== false){
            $char_is_word = true;
        }
    }

    if ( $char_is_word && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
        $sep = '';
    } else {
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $sep = ' ';
    }

    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;
    } else {
        $text = implode( $sep, $words_array );
    }

    return $text;
}
add_filter('wp_trim_words', 'trp_wp_trim_words', 100, 4);


/**
 * Use home_url in the https://www.peepso.com/ ajax front-end url so strings come back translated.
 *
 * @since 1.3.1
 *
 * @param array $data   Peepso data
 * @return array
 */
add_filter( 'peepso_data', 'trp_use_home_url_in_peepso_ajax' );
function trp_use_home_url_in_peepso_ajax( $data ){
    if ( is_array( $data ) && isset( $data['ajaxurl_legacy'] ) ){
        $data['ajaxurl_legacy'] = home_url( '/peepsoajax/' );
    }
    return $data;
}


function trp_remove_accents( $string ){

    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    if (seems_utf8($string)) {
        $chars = array(
            // Decompositions for Latin-1 Supplement
            '??' => 'a', '??' => 'o',
            '??' => 'A', '??' => 'A',
            '??' => 'A', '??' => 'A',
            '??' => 'A', '??' => 'A',
            '??' => 'AE','??' => 'C',
            '??' => 'E', '??' => 'E',
            '??' => 'E', '??' => 'E',
            '??' => 'I', '??' => 'I',
            '??' => 'I', '??' => 'I',
            '??' => 'D', '??' => 'N',
            '??' => 'O', '??' => 'O',
            '??' => 'O', '??' => 'O',
            '??' => 'O', '??' => 'U',
            '??' => 'U', '??' => 'U',
            '??' => 'U', '??' => 'Y',
            '??' => 'TH','??' => 's',
            '??' => 'a', '??' => 'a',
            '??' => 'a', '??' => 'a',
            '??' => 'a', '??' => 'a',
            '??' => 'ae','??' => 'c',
            '??' => 'e', '??' => 'e',
            '??' => 'e', '??' => 'e',
            '??' => 'i', '??' => 'i',
            '??' => 'i', '??' => 'i',
            '??' => 'd', '??' => 'n',
            '??' => 'o', '??' => 'o',
            '??' => 'o', '??' => 'o',
            '??' => 'o', '??' => 'o',
            '??' => 'u', '??' => 'u',
            '??' => 'u', '??' => 'u',
            '??' => 'y', '??' => 'th',
            '??' => 'y', '??' => 'O',
            // Decompositions for Latin Extended-A
            '??' => 'A', '??' => 'a',
            '??' => 'A', '??' => 'a',
            '??' => 'A', '??' => 'a',
            '??' => 'C', '??' => 'c',
            '??' => 'C', '??' => 'c',
            '??' => 'C', '??' => 'c',
            '??' => 'C', '??' => 'c',
            '??' => 'D', '??' => 'd',
            '??' => 'D', '??' => 'd',
            '??' => 'E', '??' => 'e',
            '??' => 'E', '??' => 'e',
            '??' => 'E', '??' => 'e',
            '??' => 'E', '??' => 'e',
            '??' => 'E', '??' => 'e',
            '??' => 'G', '??' => 'g',
            '??' => 'G', '??' => 'g',
            '??' => 'G', '??' => 'g',
            '??' => 'G', '??' => 'g',
            '??' => 'H', '??' => 'h',
            '??' => 'H', '??' => 'h',
            '??' => 'I', '??' => 'i',
            '??' => 'I', '??' => 'i',
            '??' => 'I', '??' => 'i',
            '??' => 'I', '??' => 'i',
            '??' => 'I', '??' => 'i',
            '??' => 'IJ','??' => 'ij',
            '??' => 'J', '??' => 'j',
            '??' => 'K', '??' => 'k',
            '??' => 'k', '??' => 'L',
            '??' => 'l', '??' => 'L',
            '??' => 'l', '??' => 'L',
            '??' => 'l', '??' => 'L',
            '??' => 'l', '??' => 'L',
            '??' => 'l', '??' => 'N',
            '??' => 'n', '??' => 'N',
            '??' => 'n', '??' => 'N',
            '??' => 'n', '??' => 'n',
            '??' => 'N', '??' => 'n',
            '??' => 'O', '??' => 'o',
            '??' => 'O', '??' => 'o',
            '??' => 'O', '??' => 'o',
            '??' => 'OE','??' => 'oe',
            '??' => 'R','??' => 'r',
            '??' => 'R','??' => 'r',
            '??' => 'R','??' => 'r',
            '??' => 'S','??' => 's',
            '??' => 'S','??' => 's',
            '??' => 'S','??' => 's',
            '??' => 'S', '??' => 's',
            '??' => 'T', '??' => 't',
            '??' => 'T', '??' => 't',
            '??' => 'T', '??' => 't',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            '??' => 'W', '??' => 'w',
            '??' => 'Y', '??' => 'y',
            '??' => 'Y', '??' => 'Z',
            '??' => 'z', '??' => 'Z',
            '??' => 'z', '??' => 'Z',
            '??' => 'z', '??' => 's',
            // Decompositions for Latin Extended-B
            '??' => 'S', '??' => 's',
            '??' => 'T', '??' => 't',
            // Euro Sign
            '???' => 'E',
            // GBP (Pound) Sign
            '??' => '',
            // Vowels with diacritic (Vietnamese)
            // unmarked
            '??' => 'O', '??' => 'o',
            '??' => 'U', '??' => 'u',
            // grave accent
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'E', '???' => 'e',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'U', '???' => 'u',
            '???' => 'Y', '???' => 'y',
            // hook
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'E', '???' => 'e',
            '???' => 'E', '???' => 'e',
            '???' => 'I', '???' => 'i',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'U', '???' => 'u',
            '???' => 'U', '???' => 'u',
            '???' => 'Y', '???' => 'y',
            // tilde
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'E', '???' => 'e',
            '???' => 'E', '???' => 'e',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'U', '???' => 'u',
            '???' => 'Y', '???' => 'y',
            // acute accent
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'E', '???' => 'e',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'U', '???' => 'u',
            // dot below
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'A', '???' => 'a',
            '???' => 'E', '???' => 'e',
            '???' => 'E', '???' => 'e',
            '???' => 'I', '???' => 'i',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'O', '???' => 'o',
            '???' => 'U', '???' => 'u',
            '???' => 'U', '???' => 'u',
            '???' => 'Y', '???' => 'y',
            // Vowels with diacritic (Chinese, Hanyu Pinyin)
            '??' => 'a',
            // macron
            '??' => 'U', '??' => 'u',
            // acute accent
            '??' => 'U', '??' => 'u',
            // caron
            '??' => 'A', '??' => 'a',
            '??' => 'I', '??' => 'i',
            '??' => 'O', '??' => 'o',
            '??' => 'U', '??' => 'u',
            '??' => 'U', '??' => 'u',
            // grave accent
            '??' => 'U', '??' => 'u',
        );

        // Used for locale-specific rules
        $trp = TRP_Translate_Press::get_trp_instance();
        $trp_settings = $trp->get_component( 'settings' );
        $settings = $trp_settings->get_settings();

        $default_language= $settings["default-language"];
        $locale = $default_language;

        if ( 'de_DE' == $locale || 'de_DE_formal' == $locale || 'de_CH' == $locale || 'de_CH_informal' == $locale ) {
            $chars[ '??' ] = 'Ae';
            $chars[ '??' ] = 'ae';
            $chars[ '??' ] = 'Oe';
            $chars[ '??' ] = 'oe';
            $chars[ '??' ] = 'Ue';
            $chars[ '??' ] = 'ue';
            $chars[ '??' ] = 'ss';
        } elseif ( 'da_DK' === $locale ) {
            $chars[ '??' ] = 'Ae';
            $chars[ '??' ] = 'ae';
            $chars[ '??' ] = 'Oe';
            $chars[ '??' ] = 'oe';
            $chars[ '??' ] = 'Aa';
            $chars[ '??' ] = 'aa';
        } elseif ( 'ca' === $locale ) {
            $chars[ 'l??l' ] = 'll';
        } elseif ( 'sr_RS' === $locale || 'bs_BA' === $locale ) {
            $chars[ '??' ] = 'DJ';
            $chars[ '??' ] = 'dj';
        }

        $string = strtr($string, $chars);
    } else {
        $chars = array();
        // Assume ISO-8859-1 if not UTF-8
        $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
            ."\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
            ."\xc3\xc4\xc5\xc7\xc8\xc9\xca"
            ."\xcb\xcc\xcd\xce\xcf\xd1\xd2"
            ."\xd3\xd4\xd5\xd6\xd8\xd9\xda"
            ."\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
            ."\xe4\xe5\xe7\xe8\xe9\xea\xeb"
            ."\xec\xed\xee\xef\xf1\xf2\xf3"
            ."\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
            ."\xfc\xfd\xff";

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars = array();
        $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
};

/**
 * Filter ginger_iframe_banner and ginger_text_banner to use shortcodes so our conditional lang shortcode works.
 *
 * @since 1.3.1
 *
 * @param string $content
 * @return string
 */

add_filter('ginger_iframe_banner', 'trp_do_shortcode', 999 );
add_filter('ginger_text_banner', 'trp_do_shortcode', 999 );
function trp_do_shortcode($content){
    return do_shortcode(stripcslashes($content));
}

/**
 * Debuger function. Mainly designed for the get_url_for_language() function
 *
 * @since 1.3.6
 *
 * @param bool $enabled
 * @param array $logger
 */
function trp_bulk_debug($debug = false, $logger = array()){
    if(!$debug){
        return;
    }
    error_log('---------------------------------------------------------');
    $key_length = '';
    foreach ($logger as $key => $value){
        if ( strlen($key) > $key_length)
            $key_length = strlen($key);
    }

    foreach ($logger as $key => $value){
        error_log("$key :   " . str_repeat(' ', $key_length - strlen($key)) . $value);
    }
    error_log('---------------------------------------------------------');
}

/**
 * Compatibility with WooCommerce PDF Invoices & Packing Slips
 * https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/
 *
 * @since 1.4.3
 *
 */
// fix attachment name in email
add_filter( 'wpo_wcpdf_filename', 'trp_woo_pdf_invoices_and_packing_slips_compatibility' );

// fix #trpgettext inside invoice pdf
add_filter( 'wpo_wcpdf_get_html', 'trp_woo_pdf_invoices_and_packing_slips_compatibility');
function trp_woo_pdf_invoices_and_packing_slips_compatibility($title){
	if ( class_exists( 'TRP_Translation_Manager' ) ) {
		return 	TRP_Translation_Manager::strip_gettext_tags($title);
	}
}

// fix font of pdf breaking because of str_get_html() call inside translate_page()
add_filter( 'trp_stop_translating_page', 'trp_woo_pdf_invoices_and_packing_slips_compatibility_dont_translate_pdf', 10, 2 );
function trp_woo_pdf_invoices_and_packing_slips_compatibility_dont_translate_pdf( $bool, $output ){
	if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'generate_wpo_wcpdf' ) {
		return true;
	}
	return $bool;
}


/**
 * Compatibility with WooCommerce order notes
 *
 * When a new order is placed in secondary languages, in admin area WooCommerce->Orders->Edit Order, the right sidebar contains Order notes which can contain #trpst tags.
 *
 * @since 1.4.3
 */

// old orders
add_filter( 'woocommerce_get_order_note', 'trp_woo_notes_strip_trpst' );
// new orders
add_filter( 'woocommerce_new_order_note_data', 'trp_woo_notes_strip_trpst' );
function trp_woo_notes_strip_trpst( $note_array ){
	foreach ( $note_array as $item => $value ){
		$note_array[$item] = TRP_Translation_Manager::strip_gettext_tags( $value );
	}
	return $note_array;
}

/*
 * Compatibility with WooCommerce back-end display order shipping taxes
 */
add_filter('woocommerce_order_item_display_meta_key','trp_woo_data_strip_trpst');
add_filter('woocommerce_order_item_get_method_title','trp_woo_data_strip_trpst');
function trp_woo_data_strip_trpst( $data ){
	return TRP_Translation_Manager::strip_gettext_tags( $data );
}

/**
 * Compatibility with WooCommerce country list on checkout.
 *
 * Skip detection by translate-dom-changes of the list of countries
 *
 */
add_filter( 'trp_skip_selectors_from_dynamic_translation', 'trp_woo_skip_dynamic_translation' );
function trp_woo_skip_dynamic_translation( $skip_selectors ){
	$add_skip_selectors = array( '#select2-billing_country-results', '#select2-shipping_country-results' );
	return array_merge( $skip_selectors, $add_skip_selectors );
}

/**
 * Compatibility with WooCommerce product variation.
 *
 * Add span tag to woocommerce product variation name.
 *
 * Product variation name keep changes, but the prefix is the same. Wrap the prefix to allow translating that part separately.
 */
add_filter( 'woocommerce_product_variation_title', 'trp_woo_wrap_variation', 8, 4);
function trp_woo_wrap_variation($name, $product, $title_base, $title_suffix){
	$separator  = '<span> - </span>';
	return $title_suffix ? $title_base . $separator . $title_suffix : $title_base;
}
