<div class="container pageContainer">
    <form action="<?= \Qui\lib\Routes::$routes['forum-comment-update'] . '?commentId=' . $comment['id'] ?>" method="post">
            <textarea name="comment" class="form-control" cols="4" rows="3"
                      placeholder="enter your comment.."><?= $comment['comment'] ?></textarea>
        <br/>
        <button type="submit" class="btn btn-success">
            update comment
        </button>
    </form>
</div>