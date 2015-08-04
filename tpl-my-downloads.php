<?php
/**
 * Created by shramee
 * At: 6:57 PM 4/8/15
 */

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

if ( $downloads = WC()->customer->get_downloadable_products() ) { ?>

	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

	<h2><?php echo apply_filters( 'woocommerce_my_account_my_downloads_title', __( 'Available downloads', 'woocommerce' ) ); ?></h2>

	<table class="shop_table my_account_api_manager my_account_orders">

	<thead>
	<tr>
		<th class="product-title"><span class="nobr"><?php _e( 'Product', 'woocommerce-api-manager' ); ?></span></th>

		<th class="api-manager-version"><span class="nobr"><?php _e( 'Version', 'woocommerce-api-manager' ); ?></span>
		</th>

		<th class="api-manager-documentation"><span
				class="nobr"><?php _e( 'Documentation', 'woocommerce-api-manager' ); ?></span></th>

		<th class="api-manager-download"><span class="nobr"><?php _e( 'Download', 'woocommerce-api-manager' ); ?></span>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ( $downloads as $download ) {
		$post_id = $download['product_id'];
		$dl_name = explode( ' &ndash; ', $download['download_name'] );
		?>
		<tr>
			<td> <?php echo $dl_name[0] ?> </td>

			<td>
				<?php
				$download_version = get_post_meta( $post_id, '_api_new_version', true );
				if ( ! empty( $download_version ) ) :
					echo esc_attr( $download_version );
				endif;
				?>
			</td>

			<td class="api-manager-changelog">
				<?php
				$changelog = get_post_meta( $post_id, '_api_changelog', true );
				if ( ! empty( $changelog ) ) :
					?>
					<a href="<?php echo esc_url( get_permalink( absint( $changelog ) ) ); ?>"
					   target="_blank"><?php esc_html_e( 'Changelog', 'woocommerce-api-manager' ); ?></a>
				<?php
				endif;
				?>
				<br>
				<hr>
				<?php
				$documentation = get_post_meta( $post_id, '_api_product_documentation', true );
				if ( ! empty( $documentation ) ) :
					?>
					<a href="<?php echo esc_url( get_permalink( absint( $documentation ) ) ); ?>"
					   target="_blank"><?php esc_html_e( 'Documentation', 'woocommerce-api-manager' ); ?></a>
				<?php
				endif;
				?>
			</td>

			<td> <?php echo '<a href="' . esc_url( $download['download_url'] ) . '">' . $dl_name[1] . '</a>'; ?> </td>
		</tr>

	<?php
	}
		?>
	</tbody>
</table>

	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

<?php
}