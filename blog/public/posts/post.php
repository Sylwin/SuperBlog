<?php  include('../../private/initialize.php'); ?>

<?php 
	if (isset($_GET['post-id'])) {
		$post = getPost($_GET['post-id']);
	}
	$topics = getAllTopics();
	$user = getPostAuthor($_GET['post-id']);
?>
<?php $page_title = 'Super Blog | ' . $post['post_title']; ?>
<?php include(SHARED_PATH . '/head_section.php'); ?>
	
	<?php include( SHARED_PATH . '/navbar.php'); ?>
	<div class="container">
		
		<div class="content" >
			<div class="post-wrapper">
				<div class="full-post-div">
				<?php if ($post['published'] == false): ?>
					<h2 class="post-title">Sorry... This post has not been published</h2>
				<?php else: ?>
					<h2 class="post-title"><?php echo $post['post_title']; ?></h2>
					<h3 class="post-title"><?php echo $post['description']; ?></h2>
					<hr/>
					<div class="post-body-div">
						<?php echo html_entity_decode($post['post_text']); ?>
					</div>
					<p class="post-info">
						Author: <?php echo h($user['username']) ?>;  Last update: <?php echo date("F j, Y ", strtotime(h($post["modification_date"]))); ?>
					</p>
				<?php endif ?>
				</div>

			</div>

			<div class="post-sidebar">
				<div class="card">
					<div class="card-header">
						<h2>Topics</h2>
					</div>
					<div class="card-content">
						<a href="<?php echo url_for('index.php') ?>">All posts</a> 
							<?php foreach ($topics as $topic): ?>
								
								<a style="<?php if(isset($_GET['topic']) and $_GET['topic'] == $topic['id']) { echo "font-weight: bold"; } ?>"
									href="<?php echo url_for('posts/filtered_posts.php?topic=' . h(u($topic['id']))); ?>">
									<?php echo $topic['name']; ?>
								</a> 

						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php include( SHARED_PATH . '/footer.php'); ?>