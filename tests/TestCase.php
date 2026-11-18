<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Base class for every test.
 *
 * Database tests opt in with RefreshDatabase in their own class, which migrates
 * the in-memory SQLite database once and wraps each test in a transaction.
 * This class used to add DatabaseTransactions as well; from Laravel 11 the
 * second, nested transaction breaks the shared in-memory connection
 * ("There is already an active transaction"), so it was removed.
 */
abstract class TestCase extends BaseTestCase
{
}
