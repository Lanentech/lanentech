<?php

declare(strict_types=1);

namespace App\Tests\Unit\Util\Class;

use App\Tests\TestCase\UnitTestCase;
use App\Util\Class\ClassHelper;

class ClassHelperTest extends UnitTestCase
{
    public function testGetNamespaceOfClassWithNamespace(): void
    {
        $result = ClassHelper::getNamespace('tests/Common/Fixtures/DummyClass.php');

        $this->assertEquals('App\Tests\Common\Fixtures', $result);
    }

    public function testGetNamespaceWhereClassHasNoNamespace(): void
    {
        $fileWithoutNamespace = 'tests/Common/Fixtures/DummyClassWithoutNamespace.php';
        file_put_contents($fileWithoutNamespace, '<?php class DummyClass {}');

        $namespace = ClassHelper::getNamespace($fileWithoutNamespace);
        $this->assertNull($namespace);

        unlink($fileWithoutNamespace);
    }
}
