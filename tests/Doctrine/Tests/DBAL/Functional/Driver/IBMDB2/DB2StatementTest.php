<?php

declare(strict_types=1);

namespace Doctrine\Tests\DBAL\Functional\Driver\IBMDB2;

use Doctrine\DBAL\Driver\IBMDB2\DB2Driver;
use Doctrine\Tests\DbalFunctionalTestCase;
use PHPUnit\Framework\Error\Notice;

class DB2StatementTest extends DbalFunctionalTestCase
{
    protected function setUp()
    {
        if ( ! extension_loaded('ibm_db2')) {
            $this->markTestSkipped('ibm_db2 is not installed.');
        }

        parent::setUp();

        if ( ! $this->_conn->getDriver() instanceof DB2Driver) {
            $this->markTestSkipped('ibm_db2 only test.');
        }
    }

    public function testExecutionErrorsAreNotSuppressed()
    {
        $stmt = $this->_conn->prepare('SELECT * FROM SYSIBM.SYSDUMMY1 WHERE \'foo\' = ?');

        // unwrap the statement to prevent the wrapper from handling the PHPUnit-originated exception
        $wrappedStmt = $stmt->getWrappedStatement();

        $this->expectException(Notice::class);
        $wrappedStmt->execute([[]]);
    }
}
