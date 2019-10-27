<?php require_once('../private/initialize.php') ?>

<?php 
	$posts = getPublishedPosts(); 
	$topics = getAllTopics();
?>

<?php $page_title = 'Super Blog | Home'; ?>
<?php include(SHARED_PATH . '/head_section.php') ?>

	<div class="container">

		<div class="content">
			<div class="post-wrapper">
				<h2 class="content-title">All Posts</h2>
				<hr>

				<?php foreach ($posts as $post): ?>
					<div class="post" style="margin-left: 0px;">
						<img src="<?php echo url_for('static/images/'. $post['image']); ?>" class="post_image" alt="">

						<?php if (isset($post['topic']['name'])): ?>
							<a 
								href="<?php echo url_for('posts/filtered_posts.php?topic=' . h(u($post['topic']['id']))) ?>"
								class="btn category">
								<?php echo $post['topic']['name'] ?>
							</a>
						<?php endif ?>

						<a href="posts/post.php?post-id=<?php echo h(u($post['id'])); ?>">
							<div class="post_info">
								<h3><?php echo $post['post_title'] ?></h3>
								<div class="info">
									<span><?php echo date("F j, Y ", strtotime($post["creation_date"])); ?></span>
								</div>
								<div class="info">
									<span>Author: <?php echo $post['author'] ?></span>
								</div>
							</div>
						</a>
					</div>
				<?php endforeach ?>
			</div>

			<div class="post-sidebar">
				<div class="card">
					<div class="card-header">
						<h2>Topics</h2>
					</div>
					<div class="card-content">
						<a style="font-weight: bold" href="<?php echo url_for('index.php') ?>">All</a> 
						<?php foreach ($topics as $topic): ?>
							<a 
								href="<?php echo url_for('posts/filtered_posts.php?topic=' . h(u($topic['id'])))?>">
								<?php echo $topic['name']; ?>
							</a> 
						<?php endforeach ?>
					</div>
				</div>
			</div>

		</div>

	</div>


<?php include( SHARED_PATH . '/footer.php') ?>