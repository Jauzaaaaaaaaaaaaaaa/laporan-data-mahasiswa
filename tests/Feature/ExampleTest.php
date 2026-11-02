<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_beranda_mengalihkan_ke_data_mahasiswa(): void
    {
        $this->get('/')->assertRedirect('/mahasiswa');
    }
}
