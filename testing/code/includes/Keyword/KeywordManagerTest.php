<?php

require_once __DIR__ . '\..\..\..\..\code\includes\Keyword\KeywordManager.class.php';
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-25 at 03:04:50.
 */
class KeywordManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var KeywordManager
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new KeywordManager;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * Generated from @assert ('go') == 'go'.
     *
     * @covers KeywordManager::getKeyword
     */
    public function testGetKeyword() {
        $output = $this->object->getKeyword('go');
        $output = $output[0];
        
        $this->assertEquals(
                'GO'
                , $output{'keyword'}
        );
    }

    /**
     * Generated from @assert ('notakeyword') == FALSE.
     *
     * @covers KeywordManager::addKeyword
     */
    public function testAddKeyword() {
        
        $this->MarkTestIncomplete(
        );
    }

}
