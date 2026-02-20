<?php

use config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
  public function testDatabaseClassExists()
  {
    $this->assertTrue(class_exists(Database::class));
  }
}
