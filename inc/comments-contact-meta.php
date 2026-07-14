<?php

add_action(
    'comment_post',
    function ($comment_id) {

        if (isset($_POST['contact'])) {

            add_comment_meta(
                $comment_id,
                'contact',
                sanitize_text_field(
                    wp_unslash($_POST['contact'])
                )
            );
        }
    }
);
