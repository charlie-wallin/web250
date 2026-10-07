<?php
require_once '../private/initialize.php';

/*
 * Go further choices completed in this instructor solution:
 * 2. Filter by habitat with links built from the data.
 * 3. Bird::find_by_habitat() static finder.
 */

$page_title = 'WNC Bird Inventory';
$csv = new ParseCSV();
$birds = [];
$display_birds = [];
$habitats = [];
$error_message = '';
$filter_message = '';

// ParseCSV::$delimiter is static, so this one setting changes how parse()
// interprets the bird file without editing the reusable parser class itself.
ParseCSV::$delimiter = '|';
$csv_path = PRIVATE_PATH . '/wnc-birds.csv';

try {
    $records = $csv->parse($csv_path);

    foreach ($records as $record) {
        $birds[] = new Bird($record);
    }

    // Build the habitat links from the loaded objects instead of hard-coding
    // the filter values into the page.
    $habitats = array_values(array_unique(array_map(
        function ($bird) {
            return $bird->habitat;
        },
        $birds
    )));
    sort($habitats, SORT_NATURAL | SORT_FLAG_CASE);

    $requested_habitat = $_GET['habitat'] ?? '';

    if ($requested_habitat !== '') {
        // Never trust a query-string value merely because it came from one of
        // our own links. A visitor can edit the URL, so the value is checked
        // against the known habitats before it affects program behavior.
        if (in_array($requested_habitat, $habitats, true)) {
            $display_birds = Bird::find_by_habitat($birds, $requested_habitat);
            $filter_message = 'Showing habitat: ' . $requested_habitat;
        } else {
            $display_birds = $birds;
            $filter_message = 'Unknown habitat filter. Showing all birds.';
        }
    } else {
        $display_birds = $birds;
    }
} catch (Throwable $error) {
    $error_message = 'The bird data is unavailable right now. Please check the CSV file and try again.';
}

include PRIVATE_PATH . '/shared/header.php';
?>

<h2>Bird Inventory</h2>

<?php if ($error_message !== ''): ?>
    <p><strong><?= h($error_message) ?></strong></p>
<?php else: ?>
    <p>Rows parsed: <?= h($csv->row_count()) ?></p>
    <p>Bird objects created: <?= h(Bird::$count) ?></p>

    <?php if ($filter_message !== ''): ?>
        <p><?= h($filter_message) ?></p>
    <?php endif; ?>

    <nav aria-label="Habitat filters">
        <strong>Filter by habitat:</strong>
        <a href="birds.php">All</a>
        <?php foreach ($habitats as $habitat): ?>
            | <a href="birds.php?habitat=<?= u($habitat) ?>"><?= h($habitat) ?></a>
        <?php endforeach; ?>
    </nav>

    <table border="1">
        <caption>Birds of Western North Carolina and the southern Appalachians</caption>
        <thead>
            <tr>
                <th scope="col">Bird</th>
                <th scope="col">Habitat</th>
                <th scope="col">Food</th>
                <th scope="col">Nest</th>
                <th scope="col">Behavior</th>
                <th scope="col">Wingspan</th>
                <th scope="col">Weight</th>
                <th scope="col">Size</th>
                <th scope="col">Conservation</th>
                <th scope="col">Backyard tips</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($display_birds as $bird): ?>
                <tr>
                    <td>
                        <?= h($bird->common_name) ?><br>
                        <em><?= h($bird->scientific_name) ?></em>
                    </td>
                    <td><?= h($bird->habitat) ?></td>
                    <td><?= h($bird->food) ?></td>
                    <td><?= h($bird->nest_placement) ?></td>
                    <td><?= h($bird->behavior) ?></td>
                    <td>
                        <?= h($bird->wingspan_cm()) ?><br>
                        <?= h($bird->wingspan_in()) ?>
                    </td>
                    <td>
                        <?= h($bird->weight_g()) ?><br>
                        <?= h($bird->weight_oz()) ?>
                    </td>
                    <td><?= h($bird->size_class()) ?></td>
                    <td><?= h($bird->conservation()) ?></td>
                    <td><?= h($bird->backyard_tips) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Plain-text display_name() examples</h3>
    <ul>
        <?php foreach (array_slice($display_birds, 0, 3) as $bird): ?>
            <li><?= h($bird->display_name()) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include PRIVATE_PATH . '/shared/footer.php'; ?>