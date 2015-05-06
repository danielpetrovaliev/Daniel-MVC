<?php foreach ($this->___data['posts'] as $post): ?>
    <!-- Blog Entries Column -->
    <div class="col-md-8">
        <!-- First Blog Post -->
        <h2>
            <a href="<?=$this->getBaseUrl() . "posts/" . $post['post_id']?>"><?=htmlspecialchars($post['post_title'])?></a>
        </h2>
        <i>
            <p class="lead">
                by <a href="#">
                    <?=$post['username']?>
                </a>
            </p>
        </i>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?=$post['post_created']?></p>
        <hr>
        <p>
            <?=htmlspecialchars($post['post_content'])?>
        </p>
        <a class="btn btn-primary" href=" <?=$this->getBaseUrl() . "posts/" . $post['post_id']?> ">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>

        <!-- Pager -->
        <ul class="pager">
        <!-- TODO Pagination -->
            <li class="previous">
                <a href="#">&larr; Older</a>
            </li>
            <li class="next">
                <a href="#">Newer &rarr;</a>
            </li>
        </ul>

    </div>
<?php endforeach;?>
