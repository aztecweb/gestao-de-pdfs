<?php

declare(strict_types=1);

if ( ! isset( $args['file_url'] ) ) {
	throw new Exception( '`file` argument is required in ' . __FILE__ . '.' );
}

?>
<table class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row"><label for="issue_pdf">PDF <strong>*</strong></label></th>
			<td>
				<?php if ( $args['file_url'] ) : ?>
				<p>
					<strong>
						<a href="<?php echo esc_url( $args['file_url'] ); ?>" target="_blank"><?php esc_html_e( 'Download', 'aztec' ); ?></a>
					</strong>
				</p>
				<?php endif; ?>

				<p>
					<?php
					if ( $args['file_url'] ) {
						esc_html_e( 'Send other file:', 'aztec' );
					}
					?>
					<input type="file" name="_issue_pdf" />
				</p>
			</td>
		</tr>
	</tbody>
</table>
