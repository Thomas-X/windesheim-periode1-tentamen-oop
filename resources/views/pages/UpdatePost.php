<div class="pageContainer container">
    <form method="post" action="<?= \Qui\lib\Routes::$routes['forum-post-update'] . '?id=' . $_GET['id'] ?>">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $post['name'] ?>"/>
        <br/>

        <label>Description</label>
        <textarea name="description" class="form-control">
            <?= $post['description'] ?>
        </textarea>
        <br/>

        <button type="submit" class="btn gutter1 coffeeButton noLinkStyling">
            <i class="fas fa-coffee"></i> update post
        </button>
    </form>
</div>