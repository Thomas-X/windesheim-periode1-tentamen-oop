<div class="pageContainer container">
    <form method="post" action="<?= \Qui\lib\Routes::$routes['updateBlend'] . '?id=' . $_GET['id'] ?>">

        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $blend['name'] ?>"/>
        <br/>

        <label>Description</label>
        <input type="text" name="description" class="form-control" value="<?= $blend['description'] ?>"/>
        <br/>

        <?php
        function stepIngredientHelper($count, $blend)
        {
            $stepValue = $blend['step0' . $count];
            $ingredientValue = $blend['ingredient0' . $count];
            echo "<label>Step {$count}</label>
        <input type=\"text\" name=\"step0{$count}\" class=\"form-control\" value='{$stepValue}'/>
        <br/>";
            echo "<label>Ingredient {$count}</label>
        <input type=\"text\" name=\"ingredient0{$count}\" class=\"form-control\" value='{$ingredientValue}'/>
        <br/>";
        }

        for ($i = 1; $i < 7; $i++) {
            stepIngredientHelper($i, $blend);
        }
        ?>

        <label>Time to prepare (in minutes)</label>
        <input type="number" name="timeToPrep" class="form-control" value="<?= $blend['timeToPrep'] ?>"/>
        <br/>

        <button type="submit" class="btn gutter1 coffeeButton noLinkStyling">
            <i class="fas fa-coffee"></i> update blend
        </button>
    </form>
</div>