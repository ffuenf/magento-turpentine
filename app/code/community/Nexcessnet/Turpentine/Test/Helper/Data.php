<?php
/**
* Test for class Nexcessnet_Turpentine_Helper_Data
*
* @category  Nexcessnet
* @package   Nexcessnet_Turpentine
*/

namespace Nexcessnet\Turpentine;

class Nexcessnet_Turpentine_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{

    /**
     * Tests extension version
     *
     * @test
     * @loadFixture
     */
    public function testExtensionVersion()
    {
        $this->assertEquals(Mage::helper('turpentine')->getVersion(), '0.6.2.1');
    }
}