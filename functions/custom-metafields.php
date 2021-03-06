<?php
/**
 *
 * graphviz.gv: "custom-metafields.php" -> { "classes-metabox-metafields.php"; "class-sdes-metaboxes.php"; };
 */

namespace SDES\ServicesTheme\Metafields;
require_once( get_stylesheet_directory() . '/functions/classes-metabox-metafields.php' );
	use SDES\Metafields\MetaField as Metafield;

// TODO: add QueryDropdownMetafield to extend SelectMetaField with a WP_Query for choices.
// TODO: add PosttypeMetafield to extend QueryDropdownMetafield.
// TODO: make SpotlightMetafield and IconLinkMetafield extend from PosttypeMetafield.

class SpotlightMetaField extends MetaField {

	/**
	 * @see https://github.com/UCF/Students-Theme/blob/87dca3074cb48bef5d811789cf9a07c9eac55cd1/functions/custom-fields.php#L122-L154
	 */
	public function input_html() {
		$field = $this;
		?>
		<div class="meta-spotlight-wrapper">
			<select class="meta-spotlight-field" id="<?php echo htmlentities( $field->id ); ?>" name="<?php echo htmlentities( $field->id ); ?>" value="<?php echo $field->value; ?>">
				<option value="">-- Select Spotlight --</option>
				<?php foreach( $this->get_spotlights() as $key=>$spotlight ) : ?>
				<?php $selected = $field->value == $key ? 'selected' : ''; ?>
				<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $spotlight; ?></option>
				<?php endforeach; ?>
			</select>
			<?php if ( $field->value ) : ?>
				<p></p>
				<a class="button edit-spotlight" href="<?php echo get_admin_url() . '/post.php?action=edit&post=' . $field->value; ?>" target="_blank"><span class="fa fa-pencil"></span> Edit Spotlight Items</a>
				<p>or</p>
				<a class="button" href="<?php echo get_admin_url() . '/post-new.php?post_type=spotlight'; ?>" target="_blank"><span class="fa fa-bars"></span> Create New Spotlight</a>
			<?php else : ?>
				<p>or</p>
				<a class="button" href="<?php echo get_admin_url() . '/post-new.php?post_type=spotlight'; ?>" target="_blank"><span class="fa fa-bars"></span> Create New Spotlight</a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * @see https://developer.wordpress.org/reference/functions/get_posts/ WP-Ref: get_posts()
	 * @see https://developer.wordpress.org/reference/classes/wp_query/parse_query/ WP-Ref: parse_query()
	 */
	function get_spotlights() {
		$query_args = array (
				'post_type' => 'spotlight',
			);
		$spotlights = get_posts( $query_args );
		$retval = array();
		foreach( $spotlights as $spotlight ) {
			$retval[$spotlight->ID] = $spotlight->post_title;
		}
		return $retval;
	}
}




class IconLinkMetaField extends MetaField {

	/**
	 * @see https://github.com/UCF/Students-Theme/blob/87dca3074cb48bef5d811789cf9a07c9eac55cd1/functions/custom-fields.php#L122-L154
	 */
	public function input_html() {
		$field = $this;
		?>
		<div class="meta-icon_link-wrapper">
			<select class="meta-icon_link-field" id="<?php echo htmlentities( $field->id ); ?>" name="<?php echo htmlentities( $field->id ); ?>" value="<?php echo $field->value; ?>">
				<option value="">-- Select Icon Link --</option>
				<?php foreach( $this->get_icon_links() as $key=>$icon_link ) : ?>
				<?php $selected = $field->value == $key ? 'selected' : ''; ?>
				<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $icon_link; ?></option>
				<?php endforeach; ?>
			</select>
			<?php if ( $field->value ) : ?>
				<p></p>
				<a class="button edit-icon_link" href="<?php echo get_admin_url() . '/post.php?action=edit&post=' . $field->value; ?>" target="_blank"><span class="fa fa-pencil"></span> Edit icon_link Items</a>
				<p>or</p>
				<a class="button" href="<?php echo get_admin_url() . '/post-new.php?post_type=icon_link'; ?>" target="_blank"><span class="fa fa-bars"></span> Create New icon_link</a>
			<?php else : ?>
				<p>or</p>
				<a class="button" href="<?php echo get_admin_url() . '/post-new.php?post_type=icon_link'; ?>" target="_blank"><span class="fa fa-bars"></span> Create New icon_link</a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * @see https://developer.wordpress.org/reference/functions/get_posts/ WP-Ref: get_posts()
	 * @see https://developer.wordpress.org/reference/classes/wp_query/parse_query/ WP-Ref: parse_query()
	 */
	function get_icon_links() {
		$query_args = array (
				'post_type' => 'icon_link',
			);
		$icon_links = get_posts( $query_args );
		$retval = array();
		foreach( $icon_links as $icon_link ) {
			$retval[$icon_link->ID] = $icon_link->post_title;
		}
		return $retval;
	}
}

namespace SDES\ServicesTheme;

require_once( get_stylesheet_directory() . '/functions/class-sdes-metaboxes.php' );
	use SDES\SDES_Metaboxes;

require_once( get_stylesheet_directory() . '/functions/classes-metabox-metafields.php' );
	use SDES\Metafields\IMetaField as IMetafield;

use SDES\ServicesTheme\Metafields\SpotlightMetaField;
use SDES\ServicesTheme\Metafields\IconLinkMetaField;

class ServicesMetaboxes extends SDES_Metaboxes {
	/**
	 * Displays metafields with current or default values.
	 * */
	public static function display_metafield( $post_id, $field ) {
		$field_obj = null;
		$field['value'] = get_post_meta( $post_id, $field['id'], true );
		switch ( $field['type'] ) {
			case 'spotlight':
				$field_obj = new SpotlightMetaField( $field );
				break;
			case 'icon_link':
				$field_obj = new IconLinkMetaField( $field );
				break;
			default:
				parent::display_metafield( $post_id, $field );
				return;
		}
		$markup = '';
		if ( null !== $field_obj && $field_obj instanceof IMetafield ) {
			ob_start();
		?>
			<tr>
				<th><?php echo $field_obj->label_html(); ?></th>
				<td>
					<?php echo $field_obj->description_html(); ?>
					<?php echo $field_obj->input_html(); ?>
				</td>
			</tr>
		<?php
			$markup = ob_get_clean();
		} else {
			$markup = '<tr><th></th><td>Don\'t know how to handle field of type '. $field['type'] .'</td></tr>';
		}
		echo $markup;
	}
}
