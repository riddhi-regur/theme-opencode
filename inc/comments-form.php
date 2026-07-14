<?php

/**
 * Custom Comments Form
 */

function lawfirmpro_render_comments_form()
{

	ob_start();

	comment_form(
		array(

			'title_reply'          => 'Leave a Reply',
			'title_reply_before'   => '<h2 class="lawyer-comment-title">',
			'title_reply_after'    => '</h2>',

			'logged_in_as'         => '',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',

			'class_form'           => 'lawyer-comment-form',

			'comment_field'        => '
			<p class="comment-form-comment">
				<label for="comment">Message</label>
				<textarea
					id="comment"
					name="comment"
					placeholder="Enter message"
					required
				></textarea>
			</p>',

			'fields' => array(

				'author' => '
				<p class="comment-form-author">
					<label for="author">Name</label>
					<input
						id="author"
						name="author"
						type="text"
						placeholder="Enter name"
						required
					/>
				</p>',

				'email' => '
				<p class="comment-form-email">
					<label for="email">Email</label>
					<input
						id="email"
						name="email"
						type="email"
						placeholder="Enter email"
						required
					/>
				</p>',

				'contact' => '
				<p class="comment-form-contact">
					<label for="contact">Contact</label>
					<input
						id="contact"
						name="contact"
						type="text"
						placeholder="Enter number"
					/>
				</p>',
			),

			'label_submit' => 'POST COMMENT ➔',

		)
	);

	return ob_get_clean();
}

add_shortcode(
	'lawfirmpro_comment_form',
	'lawfirmpro_render_comments_form'
);
