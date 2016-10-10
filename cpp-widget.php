<?php
/**
 * Adds Current Planetary Positions Widget
 *
 * @author	Isabel Castillo
 * @package 	Current Planetary Positions
 * @extends 	WP_Widget
 */
class cpp_widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'cpp_widget',
			__('Current Planetary Positions', 'current-planetary-positions'),
			array( 'description' => __( 'Display the current planetary positions in the zodiac signs.', 'current-planetary-positions' ), )
		);
	}

	public function isa_get_sign_position($longitude) {

		$sym = array('aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius','capricorn','aquarius','pisces');
		
		$localize_signs = array(
			__( 'Aries', 'current-planetary-positions' ),
			__( 'Taurus', 'current-planetary-positions' ),
			__( 'Gemini', 'current-planetary-positions' ),
			__( 'Cancer', 'current-planetary-positions' ),
			__( 'Leo', 'current-planetary-positions' ),
			__( 'Virgo', 'current-planetary-positions' ),
			__( 'Libra', 'current-planetary-positions' ),
			__( 'Scorpio', 'current-planetary-positions' ),
			__( 'Sagittarius', 'current-planetary-positions' ),
			__( 'Capricorn', 'current-planetary-positions' ),
			__( 'Aquarius', 'current-planetary-positions'),
			__( 'Pisces', 'current-planetary-positions') );

		foreach ( $sym as $key => $val ) {
			$symbol[$key] = '<span id="currentplanets_sprite" class="' . $val . '"></span> '. $localize_signs[$key];
		}
	
		$sign_num = floor($longitude / 30);
		$pos_in_sign = $longitude - ($sign_num * 30);
		$deg = floor($pos_in_sign);
		$full_min = ($pos_in_sign - $deg) * 60;
		$min = floor($full_min);
		$full_sec = round(($full_min - $min) * 60);
		
		$dms_numbers_range = range(0, 59);

		$localize_dms_numbers = array( 
			__('00', 'current-planetary-positions' ),
			__('01', 'current-planetary-positions' ),
			__('02', 'current-planetary-positions' ),
			__('03', 'current-planetary-positions' ),
			__('04', 'current-planetary-positions' ),
			__('05', 'current-planetary-positions' ),
			__('06', 'current-planetary-positions' ),
			__('07', 'current-planetary-positions' ),
			__('08', 'current-planetary-positions' ),
			__('09', 'current-planetary-positions' ),
			__('10', 'current-planetary-positions' ),
			__('11', 'current-planetary-positions' ),
			__('12', 'current-planetary-positions' ),
			__('13', 'current-planetary-positions' ),
			__('14', 'current-planetary-positions' ),
			__('15', 'current-planetary-positions' ),
			__('16', 'current-planetary-positions' ),
			__('17', 'current-planetary-positions' ),
			__('18', 'current-planetary-positions' ),
			__('19', 'current-planetary-positions' ),
			__('20', 'current-planetary-positions' ),
			__('21', 'current-planetary-positions' ),
			__('22', 'current-planetary-positions' ),
			__('23', 'current-planetary-positions' ),
			__('24', 'current-planetary-positions' ),
			__('25', 'current-planetary-positions' ),
			__('26', 'current-planetary-positions' ),
			__('27', 'current-planetary-positions' ),
			__('28', 'current-planetary-positions' ),
			__('29', 'current-planetary-positions' ),
			__('30', 'current-planetary-positions' ),
			__('31', 'current-planetary-positions' ),
			__('32', 'current-planetary-positions' ),
			__('33', 'current-planetary-positions' ),
			__('34', 'current-planetary-positions' ),
			__('35', 'current-planetary-positions' ),
			__('36', 'current-planetary-positions' ),
			__('37', 'current-planetary-positions' ),
			__('38', 'current-planetary-positions' ),
			__('39', 'current-planetary-positions' ),
			__('40', 'current-planetary-positions' ),
			__('41', 'current-planetary-positions' ),
			__('42', 'current-planetary-positions' ),
			__('43', 'current-planetary-positions' ),
			__('44', 'current-planetary-positions' ),
			__('45', 'current-planetary-positions' ),
			__('46', 'current-planetary-positions' ),
			__('47', 'current-planetary-positions' ),
			__('48', 'current-planetary-positions' ),
			__('49', 'current-planetary-positions' ),
			__('50', 'current-planetary-positions' ),
			__('51', 'current-planetary-positions' ),
			__('52', 'current-planetary-positions' ),
			__('53', 'current-planetary-positions' ),
			__('54', 'current-planetary-positions' ),
			__('55', 'current-planetary-positions' ),
			__('56', 'current-planetary-positions' ),
			__('57', 'current-planetary-positions' ),
			__('58', 'current-planetary-positions' ),
			__('59', 'current-planetary-positions' )
			);

		$localized_dms = array_combine($dms_numbers_range,$localize_dms_numbers);
		
		$localized_deg = $localized_dms[$deg];
		$localized_min = $localized_dms[$min];
		$localized_full_sec = isset($localized_dms[$full_sec]) ? $localized_dms[$full_sec] : _('00');

		// localize degree symbol

		if( is_rtl() ) $degree =  "&deg;$localized_deg";
		else $degree =  "$localized_deg&deg;";

		$set_out = sprintf( __( '%s %s %s%s %s%s', 'current-planetary-positions' ), 
						$degree,
						$symbol[$sign_num],
						$localized_min,
						chr(39),
						$localized_full_sec,
						chr(34)
						);

		return $set_out;

	}
	
	/**
	 * Front-end display of widget.
	 */

	public function widget( $args, $instance ) {

		wp_enqueue_style('cpp');

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Current Planetary Positions', 'current-planetary-positions' ) : $instance['title'], $instance, $this->id_base );
		$show_utc_time = empty($instance['show_utc_time']) ? false : 'on';
		
		echo $args['before_widget'];
		if ( $title ) {
			echo '<h3 class="widget-title">'. $title . '</h3>';
		}		

		// get UT/GMT time for exec */
		
		$time = new DateTime('now', new DateTimeZone('UTC'));
		
		$utdate = $time->format('j').'.'.$time->format('n').'.'.$time->format('Y');// day.month.year (single-digit day, month, 4-digit year)
		$uttime = $time->format('H').':'.$time->format('i').':'.$time->format('s');  // HH:MM:SS
		
		// set path to ephemeris
		$sweph = apply_filters( 'zp_sweph_dir', CPP_PLUGIN_DIR . 'sweph' );
		$PATH = '';
		putenv("PATH=$PATH:$sweph");
		$swetest = apply_filters( 'zp_sweph_file', 'swetest' );

		unset($out,$longitude,$speed);

		// get 12 planets/points
		$num_planets = 12;
		
		exec ("$swetest -edir$sweph -b$utdate -ut$uttime -p0123456789Dt -eswe -fPls -g, -head", $out);

		if ( empty( $out ) ) {
			echo $args['after_widget'];
			return;
		}
		
		foreach ($out as $key => $line) {
		
			$row = explode(',',$line);
			$pl_name[$key] = $row[0]; // planet name
			$longitude[$key] = $row[1]; // longitude decimal
			$speed[$key] = $row[2]; // speed
		}
		// localize planet names
		$pl_name = array(
			__( 'Sun', 'current-planetary-positions' ),
			__( 'Moon', 'current-planetary-positions' ),
			__( 'Mercury', 'current-planetary-positions' ),
			__( 'Venus', 'current-planetary-positions' ),
			__( 'Mars', 'current-planetary-positions' ),
			__( 'Jupiter', 'current-planetary-positions' ),
			__( 'Saturn', 'current-planetary-positions' ),
			__( 'Uranus', 'current-planetary-positions' ),
			__( 'Neptune', 'current-planetary-positions' ),
			__( 'Pluto', 'current-planetary-positions' ),
			__( 'Chiron', 'current-planetary-positions'),
			__( 'TrueNode', 'current-planetary-positions')
			);

		?>
		<div id="current-planets">
		<?php 

		// if Show UTC option is checked, show it instead
		if ( $show_utc_time ) {
	
			$utc_display_date = $time->format('j').'-'.$time->format('M').'-'.$time->format('Y');// like 3-Apr-2014
			$utc_display_time = $time->format('H').':'.$time->format('i');  // HH:MM
					
			echo '<p id="utc-time">' . esc_html( $utc_display_date ) . ', ' . esc_html( $utc_display_time ) . ' UT/GMT';

		} else {

			// display local date and time
			echo '<p id="localtime">'; ?><script>var d=new Date();var n=d.toLocaleDateString();var t=d.toLocaleTimeString();document.write(n + "<br />" + t);</script><?php
		}

		echo '</p><table>';

		for ($i = 0; $i <= $num_planets - 1; $i++) {

			$position = $this->isa_get_sign_position( $longitude[ $i ] );

			echo '<tr><td>' . $pl_name[$i] . '&nbsp;</td><td>';
			echo wp_kses_post( $position );
			if ( $speed[ $i ] < 0 ) { //retrograde
				echo '&nbsp;' . __('R', 'current-planetary-positions' );
			}
			echo  '</td></tr>';
		}
		echo "</table></div>";
		echo $args['after_widget'];
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_utc_time'] = empty($new_instance['show_utc_time']) ? false : 'on';
		return $instance;
	}

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		$defaults = array( 
			'title' => __('Current Planetary Positions', 'current-planetary-positions'),
			'show_utc_time' => false
			);
 		$instance = wp_parse_args( (array) $instance, $defaults );
    	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title:', 'current-planetary-positions' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" 
				name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p><input id="<?php echo $this->get_field_id( 'show_utc_time' ); ?>" name="<?php echo $this->get_field_name( 'show_utc_time' ); ?>" type="checkbox" class="checkbox" <?php checked( $instance['show_utc_time'], 'on' ); ?> /><label for="<?php echo $this->get_field_id( 'show_utc_time' ); ?>"><?php _e( ' Show UT/GMT time instead of viewer\'s local time.', 'current-planetary-positions' ); ?></label></p>
		<?php 
	}
}
?>