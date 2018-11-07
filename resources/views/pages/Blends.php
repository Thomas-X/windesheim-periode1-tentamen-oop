<div class="pageContainer">
    <!--    blends waiting approval -->
    <!--    blends recently approved -->
    <!--    all approved blends -->

    <div class="container">
        <div class="row" style="padding: 0 0 3rem 0;">
            <div class="col-sm-12 col-md-8 maxListHeight">
                <img src="images/blends.jpeg" class="fitContainer"/>
            </div>
            <div class="col-sm-12 col-md-4 flexColumn maxListHeight">
                <h1 class="display-4 text-muted">
                    <i>Our blends</i>
                </h1>
                <a class="btn gutter1 coffeeButton noLinkStyling" href="<?= \Qui\lib\Routes::$routes['addBlend'] ?>">
                    <i class="fas fa-coffee"></i> add a blend
                </a>
                <ul class="list-group" style="flex: 1; overflow-y: auto;">
                    <?php foreach ($blends as $blend): ?>
                        <li class="list-group-item">
                            <?= $blend['name'] ?>
                            <p class="text-muted">
                                <i class="fas fa-clock"></i> <?= $blend['timeToPrep'] ?> minutes prepare time
                            </p>
                            <?php

                            $user = \Qui\lib\facades\Authentication::verify(true);
                            if ($user['roleid'] > 1)
                                continue;
                            ?>
                            <div class="buttongrid">
                                <a class="btn btn-info" href="<?= \Qui\lib\Routes::$routes['updateBlend'] . '?id=' . $blend['id'] ?>">
                                    update
                                </a>
                                <form method="post" action="<?= \Qui\lib\Routes::$routes['removeBlend'] . '?id=' . $blend['id'] ?>">
                                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                                        delete
                                    </button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 flexColumn maxListHeight">
                <h1 class="text-muted">
                    Blends awaiting approval
                </h1>

                <ul class="list-group" style="flex: 1; overflow-y: auto;">
                    <?php foreach ($blendsAwaitingApproval as $blend): ?>
                        <li class="list-group-item">
                            <?= $blend['name'] ?>
                            <p class="text-muted">
                                <i class="fas fa-clock"></i> <?= $blend['timeToPrep'] ?> minutes prepare time
                            </p>
                            <?php

                            $user = \Qui\lib\facades\Authentication::verify(true);
                            if ($user['roleid'] > 1)
                                continue;
                            ?>
                            <div class="buttongrid">
                                <div></div>
                                <form method="post" action="<?= \Qui\lib\Routes::$routes['approveBlend'] . '?id=' . $blend['id'] ?>">
                                    <button type="submit" class="btn btn-success" style="width: 100%;">
                                        approve blend
                                    </button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-sm-12 col-md-6 flexColumn maxListHeight">
                <h1 class="text-muted">
                    Blends recently approved
                </h1>
                <ul class="list-group" style="flex: 1; overflow-y: auto;">
                    <?php foreach ($blendsRecentlyApproved as $blend): ?>
                        <li class="list-group-item">
                            <?= $blend['name'] ?>
                            <p class="text-muted">
                                <i class="fas fa-clock"></i> <?= $blend['timeToPrep'] ?> minutes prepare time
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </div>

</div>