<div id="jblog-contributor-list">
    <?php if ( ! empty( $contributors ) ) : ?>
    <h4><?php esc_html_e( 'Contributors', 'jblog-contributors' ); ?>:</h4>
    <ul class="jbc-list">
        <?php
        foreach ( $contributors as $contributor ) :
            $user = get_userdata( $contributor );
            if ( $user ) :
                ?>
                <li class="jbc-list-item item-<?php echo esc_attr( $user->ID ); ?>">
                    <?php echo get_avatar( $user->ID, 24, 'retro', esc_attr__( 'User avatar', 'jblog-contributors' ) ); ?>
                    &nbsp;&nbsp;
                    <span>
                        <a href="<?php echo esc_url_raw( get_author_posts_url( $user->ID ) ); ?>">
                            <?php echo esc_html( $user->display_name ); ?>
                        </a>
                    </span>
                </li>
                <?php
            endif;
        endforeach;
        ?>
    </ul>
    <?php endif; ?>
    <?php wp_nonce_field( 'jblog-contributors-checklist-nonce', 'jblog_contributors_checklist_nonce' ); ?>
</div>
