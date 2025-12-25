<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoCanonicalTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function test_homepage_has_canonical_tag(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();

        // Construct the expected canonical tag. 
        // In testing, Laravel usually defaults to localhost.
        // We verify that the canonical link points to the current URL of the request.
        $expectedUrl = route('home');

        $response->assertSee('<link rel="canonical" href="' . $expectedUrl . '"', false);
    }
}
