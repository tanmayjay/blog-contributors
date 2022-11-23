<div id="jblog-contributor-checklist">
    <?php if ( ! empty( $users ) ) : ?>
    <select class="jbc-checklist" name="jblog_contributors[]" multiple="multiple">
        <?php foreach ( $users as $user ) : ?>
        <option value="<?php echo esc_attr( $user->ID ); ?>" <?php selected( in_array( $user->ID, $contributors, true ) ) ?> >
            <?php echo esc_html( $user->display_name ); ?>
        </option>
        <?php endforeach; ?>
    </select>
    <?php endif; ?>
    <?php wp_nonce_field( 'jblog-contributors-checklist-nonce', 'jblog_contributors_checklist_nonce' ); ?>
</div>
