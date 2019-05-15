<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to starkers_comment() which is
 * located in the functions.php file.
 *
 * @package 	WordPress
 * @subpackage 	Bootstrap 4.1.3
 * @autor 		Babobski
 */
?>
<div id="comments-wrapper">
	<div class="container">
		<?php if ( post_password_required() ) : ?>
		<p>
			<?php _e( 'This post is password protected. Enter the password to view any comments', 'idg-wp' ); ?>
		</p>
	</div>
</div>

	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>

		<h3>Comentários</h3>

		<ul class="comments-list">
			<?php wp_list_comments( array( 'callback' => 'bootstrap_comment' ) ); ?>
		</ul>
	
	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		
		<p>
			<?php echo __('Comments are closed', 'idg-wp')?>
		</p>
	
	<?php endif; ?>

	<?php
	/*
	 * Adding bootstrap support to comment form,
	 * and some form validation using javascript.
	 */
	
	ob_start();
	$commenter = wp_get_current_commenter();
	$req = true;
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$comments_arg = array(
		'form'	=> array(
			'class' => 'form-horizontal'
			),
		'fields' => apply_filters( 'comment_form_default_fields', array(
				'autor' 				=> '<div class="form-group">' . '<label for="author">' . __( 'Nome', 'idg-wp' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
										'<input id="author" name="author" class="form-control" type="text" value="" size="30"' . $aria_req . ' />'.
										'<p id="d1" class="text-danger"></p>' . '</div>',
				'email'					=> '<div class="form-group">' .'<label for="email">' . __( 'E-mail', 'idg-wp' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
										'<input id="email" name="email" class="form-control" type="text" value="" size="30"' . $aria_req . ' />'.
										'<p id="d2" class="text-danger"></p>' . '</div>',
				'url'					=> '')),
				'comment_field'			=> '<div class="form-group">' . '<label for="comment">' . __( 'Comentário', 'idg-wp' ) . '</label><span>*</span>' .
										'<textarea id="comment" class="form-control" name="comment" rows="3" aria-required="true"></textarea><p id="d3" class="text-danger"></p>' . '</div>',
				'comment_notes_after' 	=> '',
				'class_submit'			=> 'btn btn-default mt-4'
			); ?>
	<?php comment_form($comments_arg);
	echo str_replace('class="comment-form"','class="comment-form" name="commentForm" onsubmit="return validateForm();"',ob_get_clean());
	?>
	
		<script>
			/* basic javascript form validation */
			function validateForm() {
			var form 	=  document.forms["commentForm"];
				x 		= form["author"].value,
				y 		= form["email"].value,
				z 		= form["comment"].value,
				flag 	= true,
				d1 		= document.getElementById("d1"),
				d2 		= document.getElementById("d2"),
				d3 		= document.getElementById("d3");
				
			if (x == null || x == "") {
				d1.innerHTML = "<?php echo __('O nome é obrigatório', 'idg-wp'); ?>";
				z = false;
			} else {
				d1.innerHTML = "";
			}
			
			if (y == null || y == "") {
				d2.innerHTML = "<?php echo __('O E-mail é obrigatório', 'idg-wp'); ?>";
				z = false;
			} else {
				d2.innerHTML = "";
			}
			
			if (z == null || z == "") {
				d3.innerHTML = "<?php echo __('O comentário é obrigatório', 'idg-wp'); ?>";
				z = false;
			} else {
				d3.innerHTML = "";
			}
			
			if (z == false) {
				return false;
			}
			
		}
	</script>
	
	
</div>