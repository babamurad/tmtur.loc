<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Log;
use App\Models\Tour;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

// Simulate request
try {
    echo "Testing Pagination...\n";

    // Check if page 1 works
    $page1 = Tour::with('categories', 'media')->paginate(12, ['*'], 'page', 1);
    echo "Page 1 count: " . $page1->count() . "\n";

    // Check if page 2 works
    $page2 = Tour::with('categories', 'media')->paginate(12, ['*'], 'page', 2);
    echo "Page 2 count: " . $page2->count() . "\n";

    if ($page2->isEmpty()) {
        echo "Page 2 is empty.\n";
    }

} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
