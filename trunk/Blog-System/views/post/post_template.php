<?php
$post = $this->___data['post'];
$comments = $this->___data['comments'];
?>
<!-- Blog Post Content Column -->
<div class="col-lg-8">
    <!-- Title -->
    <h1><?= htmlspecialchars($post['post_title']) ?> <span style="font-size: 14px; padding: 15px;" class="pull-right"><span class="glyphicon glyphicon-eye-open"></span> <?= htmlspecialchars($post['visits']) ?></span> </h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">
            <?= htmlspecialchars($post['username']) ?>
        </a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?= htmlspecialchars($post['post_created']) ?></p>

    <hr>

    <hr>

    <!-- Post Content -->
    <p>
        <?= htmlspecialchars($post['post_content']) ?>
    </p>

    <hr>

    <!-- Blog Comments -->
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>

        <form action=" <?= $this->getBaseUrl() . "comments/add/" . $post['post_id'] ?> " method="post" role="form">
            <div class="form-group col-md-6">
                <label for="user_name">Username: </label>
                <input required id="user_name" name="user_name" type="text"/>
            </div>
            <div class="form-group col-md-6">
                <label for="user_email">Email: </label>
                <input id="user_email" name="user_email" type="email"/>
            </div>
            <div class="form-group">
                <textarea required name="content" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <hr>

    <!-- Posted Comments -->

    <!-- Comment -->
    <?php foreach ($comments as $comment) : ?>
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>

            <div class="media-body">
                <h4 class="media-heading">
                    <?= htmlspecialchars($comment['user_name']) ?>
                    <small>
                        <?= htmlspecialchars($comment['created']) ?>
                    </small>
                </h4>
                <?= htmlspecialchars($comment['content']) ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>