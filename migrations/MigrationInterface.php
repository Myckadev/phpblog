<?php

namespace Migrations;

interface MigrationInterface
{
    public function up(): void;

    public function down(): void;

    public function description();
}