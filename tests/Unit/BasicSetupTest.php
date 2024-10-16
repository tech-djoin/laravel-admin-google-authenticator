<?php

namespace TechDjoin\LaravelAdminGoogleAuthenticator\Tests\Unit;

use TechDjoin\LaravelAdminGoogleAuthenticator\Tests\TestCase;

class BasicSetupTest extends TestCase
{
    /** @test */
    public function config_file_exists()
    {
        $this->assertFileExists(__DIR__ . '/../../config/google2fa.php');
    }

    /** @test */
    public function migration_file_exists()
    {
        $migrationFile = glob(__DIR__ . '/../../database/migrations/*_add_google2fa_column_to_admin_users_table.php');
        $this->assertNotEmpty($migrationFile);
    }
}