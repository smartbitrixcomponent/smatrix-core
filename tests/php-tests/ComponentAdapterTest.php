<?php
use PHPUnit\Framework\TestCase;
require __DIR__."/../../local/core/class/Core.php";

final class ComponentAdapterTest extends TestCase {
    public function testCanBeGetValidPath() {
        $component = new ComponentAdapter("button", ".default", array(), null, array());
        $this->assertEquals(
            'user@example.com',
            'ssd'
        );
    }
}
