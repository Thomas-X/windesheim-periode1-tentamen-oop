<div class="container pageContainer">
    <div class="jumbotron">
        <h1>
            <?= $post['name'] ?>
        </h1>
    </div>
    <p>
        <?= $post['description'] ?>
    </p>

    <hr/>
    <div class="flexColumn" style="margin-bottom: 3rem;">
        <label>create a comment</label>
        <form action="<?= \Qui\lib\Routes::$routes['forum-comment-create'] . '?postId=' . $post['id'] ?>" method="post">
            <textarea name="comment" class="form-control" cols="4" rows="3"
                      placeholder="enter your comment.."></textarea>
            <br/>
            <button type="submit" class="btn btn-success">
                create comment
            </button>
        </form>
    </div>

    <?php foreach ($comments as $comment) : ?>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-sm-12 col-md-1 center-container flexColumn">
                <form action="<?= \Qui\lib\Routes::$routes['forum-comment-vote'] . '?vote=' . '1' . '&commentId=' . $comment['id'] . '&postId=' . $post['id'] ?>"
                      method="post">
                    <button type="submit" class="noButtonStyling">
                        <i class="fas fa-arrow-up" style="color: orangered"></i>
                    </button>
                </form>

                <p style="margin:0;"><?= $comment['votes'] ?></p>

                <form action="<?= \Qui\lib\Routes::$routes['forum-comment-vote'] . '?vote=' . '-1' . '&commentId=' . $comment['id'] . '&postId=' . $post['id'] ?>"
                      method="post">
                    <button type="submit" class="noButtonStyling">
                        <i class="fas fa-arrow-down blueColor"></i>
                    </button>
                </form>
            </div>
            <div class="col-sm-12 col-md-3 center-container flexColumn">
                <?= $comment['fname'] . $comment['lname'] ?>
                <br/>
                <p class="text-muted">
                    On <?= $comment['lastTimeStamp'] ?>
                </p>
            </div>
            <div class="col-sm-12 col-md-8" style="padding: 1rem">
                <p>
                    <?= $comment['comment'] ?>
                </p>

                <div class="buttongrid">
                    <?php
                    $user = \Qui\lib\facades\Authentication::verify(true);

                    if ($user['id'] == $comment['creatorid']) {
                        $editRoute = \Qui\lib\Routes::$routes['forum-comment-update'] . '?id=' . $comment['id'];
                        $removeRoute = \Qui\lib\Routes::$routes['forum-comment-delete'] . '?id=' . $comment['id'];
                        echo "<a href=\"{$editRoute}\" class=\"btn btn-info\">
                            edit comment
                         </a>";
                        echo "<form action=\"{$removeRoute}\" method=\"post\">
                <button type=\"submit\" class=\"btn btn-danger\" style='width:100%;'>
                    remove comment
                </button>
            </form>";
                    }

                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>