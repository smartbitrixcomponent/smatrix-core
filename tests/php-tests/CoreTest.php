<?php
use PHPUnit\Framework\TestCase;

final class ComponentAdapterTest extends TestCase {
    public function testCanBeGetValidSiteTemlateName() {
        $APPLICATION = Core::getInstance();
        $APPLICATION->setSiteTemplate('site');

        $this->assertEquals(
            'site',
            $APPLICATION->getSiteTemplate()
        );
    }
    public function testCanBeGetHTMLTags() {
        $APPLICATION = Core::getInstance();
        $APPLICATION->setSiteTemplate('site');
        $this->assertEquals(
            '<__css__></__css__>',
            $APPLICATION::CSS_TEMPLATE
        );
    }
}
