<?php
$mostCommonTags = $this->___data['most_common_tags'];
?>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Search by tag</h4>

        <div class="input-group col-md-10">
            <form action=" <?= $this->getBaseUrl() . 'posts/getPostsByTagTitle' ?> " method="GET">
                <input type="text" name="tagQuery" class="form-control col-md-3">
                <span class="input-group-btn" style="display: inherit;">
                    <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </form>
        </div>
        <!-- /.input-group -->
    </div>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Last 10 posts</h4>

        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php foreach($this->___data['sorted_posts'] as $post): ?>
                        <li>
                            <a href="<?= $this->getBaseUrl() . 'posts/get/' . $post['post_id'] ?>"><?= $post['post_title'] ?></a> by <i><?= $post['username'] ?></i>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- Side Widget Well -->
    <div class="well">
        <h4>Most common tags</h4>
        <ul class="list-unstyled">
            <?php foreach($mostCommonTags as $tag): ?>
                <li>
                    <a href="<?= $this->getBaseUrl() . 'posts/getByTag/' . $tag['id'] ?>">
                        <?= $tag['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>