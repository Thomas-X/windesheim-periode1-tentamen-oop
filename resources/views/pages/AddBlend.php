<div class="pageContainer container">
    <form method="post" action="<?= \Qui\lib\Routes::$routes['addBlend'] ?>">

        <label>Name</label>
        <input type="text" name="name" class="form-control"/>
        <br/>

        <label>Description</label>
        <input type="text" name="description" class="form-control"/>
        <br/>

        <?php
        function stepIngredientHelper ($count) {
            echo "<label>Step {$count}</label>
        <input type=\"text\" name=\"step0{$count}\" class=\"form-control\"/>
        <br/>";
            echo "<label>Ingredient {$count}</label>
        <input type=\"text\" name=\"ingredient0{$count}\" class=\"form-control\"/>
        <br/>";
        }

        for ($i = 1; $i < 7;$i++) {
            stepIngredientHelper($i);
        }

        ?>

        <label>Time to prepare (in minutes)</label>
        <input type="number" name="timeToPrep" class="form-control"/>
        <br/>

        <button type="submit" class="btn gutter1 coffeeButton noLinkStyling">
            <i class="fas fa-coffee"></i> add blend
        </button>
    </form>
</div>