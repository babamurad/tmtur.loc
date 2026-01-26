<?php

use App\Models\Tour;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\TourAccommodation;
use Illuminate\Support\Facades\DB;

// Ensure we have a location and hotels
$location = Location::firstOrCreate(['name' => 'Test Location'], ['slug' => 'test-location']);

$hotelStandard1 = Hotel::firstOrCreate(['name' => 'Standard Hotel 1', 'location_id' => $location->id], ['category' => 'standard']);
$hotelStandard2 = Hotel::firstOrCreate(['name' => 'Standard Hotel 2', 'location_id' => $location->id], ['category' => 'standard']);
$hotelComfort1 = Hotel::firstOrCreate(['name' => 'Comfort Hotel 1', 'location_id' => $location->id], ['category' => 'comfort']);
$hotelComfort2 = Hotel::firstOrCreate(['name' => 'Comfort Hotel 2', 'location_id' => $location->id], ['category' => 'comfort']);

// Create a Tour
echo "Creating Tour...\n";
$tour = Tour::create([
    'title' => 'Test Tour Multiple Hotels',
    'slug' => 'test-tour-multiple-hotels-' . uniqid(),
    'base_price' => 1000,
    'duration_days' => 5,
]);

// Create Accommodation via Model directly (simulating Action logic)
echo "Creating Accommodation...\n";
$acc = TourAccommodation::create([
    'tour_id' => $tour->id,
    'nights_count' => 2,
    'location_id' => $location->id,
    'location' => 'Test Location',
]);

// Attach Hotels
echo "Attaching Hotels...\n";
$acc->hotels()->attach($hotelStandard1->id, ['type' => 'standard']);
$acc->hotels()->attach($hotelStandard2->id, ['type' => 'standard']);
$acc->hotels()->attach($hotelComfort1->id, ['type' => 'comfort']);
$acc->hotels()->attach($hotelComfort2->id, ['type' => 'comfort']);

// Verify
echo "Verifying...\n";
$acc->refresh();

$standards = $acc->standardHotels;
$comforts = $acc->comfortHotels;

echo "Standard Hotels Count: " . $standards->count() . "\n";
foreach ($standards as $h) {
    echo " - " . $h->name . "\n";
}

echo "Comfort Hotels Count: " . $comforts->count() . "\n";
foreach ($comforts as $h) {
    echo " - " . $h->name . "\n";
}

if ($standards->count() == 2 && $comforts->count() == 2) {
    echo "SUCCESS: Multiple hotels attached correctly.\n";
} else {
    echo "FAILURE: Incorrect hotel counts.\n";
}

// Clean up
$tour->forceDelete(); // Should cascade accommodations
// Hotels and Location kept
