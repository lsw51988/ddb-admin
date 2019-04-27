<?php
require __DIR__ . '/../../bootstrap/bootstrap.php';

use Ddb\Core\Utils\Generator;

$option = [
    'modelsDir' => '../app/Models',
    'force' => true,
    'namespace' => 'Ddb\Models',
    'extends' => 'BaseModel',
    'genDocMethods' => true,
    'genSettersGetters' => true,
    'abstract' => false
];

if ($argc < 2) {
    echo "Usage: makemodels.sh [all|table-name]" . PHP_EOL;
    die();
}

try {
    if ($argv[1] == 'all') {
        $tool = new Generator\AllModels($option);
        $tool->build();
    } else {
        $option['name'] = $argv[1];
        $tool = new Generator\Model($option);
        $tool->build();
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
