<?php include('../../private/initialize.php'); ?>

<?php 
	if (isset($_GET['topic'])) {
		$topic_id = $_GET['topic'];
		$posts = getPublishedPostsByTopic($topic_id);
	}

	$topics = getAllTopics();
?>
<?php 
	if(isset($_GET['topic'])) {
		$page_title = 'Super Blog | ' . getTopicNameById($_GET['topic']);
	} else {
		$page_title = 'Super Blog | Topic'; 
	}
?>
<?php include(SHARED_PATH . '/head_section.php'); ?>

		<div class="container">
			<div class="content">
				<div class="post-wrapper">
					<h2 class="content-title">
						Posts on <u><?php echo getTopicNameById($topic_id); ?></u>
					</h2>
					<hr>
					<?php foreach ($posts as $post): ?>
						<div class="post" style="margin-left: 0px;">
							<img src="<?php echo url_for('/static/images/' . $post['image']); ?>" class="post_image" alt="">
							<a href="post.php?post-id=<?php echo h(u($post['id'])); ?>">
								<div class="post_info">
									<h3><?php echo $post['post_title'] ?></h3>
									<div class="info">
										<span><?php echo date("F j, Y ", strtotime($post["creation_date"])); ?></span>
										<span class="read_more">Read more...</span>
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

<!-- Footer -->
	<?php include( SHARED_PATH . '/footer.php'); ?>
<!-- // Footer -->