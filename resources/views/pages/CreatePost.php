<div class="pageContainer container">
    <form method="post" action="<?= \Qui\lib\Routes::$routes['forum-post-create'] ?>">
        <label>Name</label>
        <input type="text" name="name" class="form-control"/>
        <br/>

        <label>Description</label>
        <textarea name="description" class="form-control">

        </textarea>
        <br/>

        <button type="submit" class="btn gutter1 coffeeButton noLinkStyling">
            <i class="fas fa-coffee"></i> create post
        </button>
    </form>
</div>