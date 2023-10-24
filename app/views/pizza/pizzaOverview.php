<?php require APPROOT . '/views/includes/head.php'; ?>

<h3 class="text-center"><?= $data['title'] ?></h3>

<div class="container max-width-adaptive-lg" style="display: flex; height: 50%;">
    <div style="background-color: azure;" class="col-2">
        <h4>Ingredients Filter</h4>
        <form method="get" action="<?= URLROOT ?>pizzacontroller/pizzaOverview/1/">
            <ul>
                <?php foreach ($data['ingrediënten'] as $ingrediënt) : ?>
                    <li>
                        <label>
                            <input type="checkbox" name="selected_ingredients[]" value="<?php echo $ingrediënt->ingredientName; ?>">
                            <?php echo $ingrediënt->ingredientName; ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button class="btn btn-success " type="submit">Filter</button>
            <a href="<?= URLROOT ?>pizzacontroller/pizzaOverview/1/" class="btn btn-success ">Reset Filter</a>
        </form>
    </div>


    <div class="grid gap-sm">
        <?php foreach ($data['pizza'] as $pizza) : ?>
            <div class="prod-card col-6@sm">
                <a class="prod-card__img-link" href="" aria-label="Description of the link">
                    <figure class="prod-card__img ">
                        <img src="<?= URLROOT . $pizza->pizzaPath ?>" alt="Pizza pictures">
                    </figure>
                </a>

                <div class="padding-sm text-center">
                    <h3 class="color-inherit"><?= $pizza->pizzaName ?></h3>

                    <div class="margin-top-xs">
                        <span class="prod-card__price">€<?= $pizza->pizzaPrice ?></span>
                    </div>
                    <button class="btn btn--primary addToCartBtn">Add To Cart</button>
                    <input type="hidden" class="pizzaId" value="<?= $pizza->pizzaId ?>">
                    <input type="hidden" class="pizzaName" value="<?= $pizza->pizzaName ?>">
                    <input type="hidden" class="pizzaPrice" value="<?= $pizza->pizzaPrice ?>">
                    <input type="hidden" class="pizzaPath" value="<?= $pizza->pizzaPath ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <div class="drawer dr-cart js-drawer" id="drawer-cart-id">
        <div class="drawer__content bg-light inner-glow shadow-md flex flex-column" role="alertdialog" aria-labelledby="drawer-cart-title">
            <header class="flex items-center justify-between flex-shrink-0 border-bottom border-contrast-lower padding-x-sm padding-y-xs">
                <h1 id="drawer-cart-title" class="text-base text-truncate">Your Cart (2)</h1>

                <button class="reset drawer__close-btn js-drawer__close js-tab-focus">
                    <svg class="icon icon--xs" viewBox="0 0 16 16">
                        <title>Close drawer panel</title>
                        <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                            <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                            <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                        </g>
                    </svg>
                </button>
            </header>

            <div class="drawer__body padding-x-sm padding-bottom-sm js-drawer__body">
                <ol id="selectedPizzasList">
                </ol>
            </div>

            <footer class="padding-x-sm padding-y-xs border-top border-contrast-lower flex-shrink-0">
                <p class="text-sm flex justify-between" id="totalPrice"><span>Subtotal:</span> <span></span></p>
                <a href="<?= URLROOT; ?>pizzacontroller/pizzaCheckout" class="btn btn--primary btn--md width-100% margin-top-xs">Checkout &rarr;</a>
            </footer>
        </div>
    </div>
</div>

<nav class="pagination " aria-label="Pagination">
    <ol class="pagination__list flex flex-wrap gap-xxxs justify-center">
        <li>
            <a href="#0" class="pagination__item pagination__item--disabled" aria-label="Go to previous page">
                <svg class="icon icon--xs margin-right-xxxs flip-x" viewBox="0 0 16 16">
                    <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span>Prev</span>
            </a>
        </li>

        <li class="display@sm">
            <a href="#0" class="pagination__item" aria-label="Go to page 1">1</a>
        </li>

        <li class="display@sm">
            <a href="#0" class="pagination__item" aria-label="Go to page 2">2</a>
        </li>

        <li class="display@sm">
            <a href="#0" class="pagination__item pagination__item--selected" aria-label="Current Page, page 3" aria-current="page">3</a>
        </li>

        <li class="display@sm">
            <a href="#0" class="pagination__item" aria-label="Go to page 4">4</a>
        </li>

        <li class="display@sm" aria-hidden="true">
            <span class="pagination__item pagination__item--ellipsis">...</span>
        </li>

        <li class="display@sm">
            <a href="#0" class="pagination__item" aria-label="Go to page 20">20</a>
        </li>

        <li>
            <a href="#0" class="pagination__item" aria-label="Go to next page">
                <span>Next</span>
                <svg class="icon icon--xs margin-left-xxxs" viewBox="0 0 16 16">
                    <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>
        </li>
    </ol>
</nav>

<?php if (!empty($data['pageNumber'])) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <!-- Dit lijstitem wordt gebruikt voor de "Vorige" paginaknop. De 'disabled' class wordt toegevoegd als de waarde van $data['previousPage']
         kleiner is dan of gelijk is aan 0, wat aangeeft dat er geen vorige pagina is om naar terug te keren.
         De knop leidt naar de vorige pagina in de reeks. -->
            <li class="page-item <?= ($data['previousPage'] <= 0) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/<?= $data['previousPage'] ?>/<?= $data['urlQuery'] ?>">Previous</a>
            </li>
            <!-- Dit is een lijstitem voor de eerste paginaknop. Als de huidige pagina de eerste pagina is, wordt 'active' toegevoegd
         aan de class van het element, anders wordt het vorige paginanummer of de volgende pagina minus 2 weergegeven. -->
            <li class="page-item <?= ($data['pageNumber'] == 1) ? 'active' : ''; ?>"><a class="page-link" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/<?= $data['firstPage'] ?>/<?= $data['urlQuery'] ?>">
                    <?= $data['firstPage'] ?>
                </a></li>
            <?php if ($data['totalPages'] >= 2) : ?>
                <li class="page-item <?= ($data['pageNumber'] != 1 && $data['totalPages'] != $data['pageNumber'] || ($data['totalPages'] == 2 && $data['pageNumber'] == 2)) ? 'active' : ''; ?>"><a class="page-link" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/<?= $data['secondPage'] ?>/<?= $data['urlQuery'] ?>">
                        <?= $data['secondPage'] ?>
                    </a></li>
            <?php endif; ?>

            <?php if ($data['totalPages'] >= 3) : ?>
                <li class="page-item <?= ($data['pageNumber'] == $data['totalPages']) ? 'active' : ''; ?>"><a class="page-link" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/<?= $data['thirdPage'] ?>/<?= $data['urlQuery'] ?>">
                        <?= $data['thirdPage'] ?>
                    </a></li>
            <?php endif; ?>
            <li class="page-item <?= ($data['nextPage'] > $data['totalPages']) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/<?= $data['nextPage'] ?>/<?= $data['urlQuery'] ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>




<style>
    html,
    body {
        height: 100%;
    }
</style>

<script src="<?= URLROOT; ?>public/js/app.js"></script>

<?php require APPROOT . '/views/includes/footer.php'; ?>