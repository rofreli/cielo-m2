<?php
/**
 * Jefferson Porto
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  Az2009
 * @package   Az2009_Cielo
 *
 * @copyright Copyright (c) 2018 Jefferson Porto - (https://www.linkedin.com/in/jeffersonbatistaporto/)
 *
 * @author    Jefferson Porto <jefferson.b.porto@gmail.com>
 */
namespace Az2009\Cielo\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales_order_payment'), 'card_token')) {
            $installer->run("
                ALTER TABLE {$installer->getTable('sales_order_payment')} 
                  ADD COLUMN card_token VARCHAR(100) DEFAULT NULL"
            );
        }

        $installer->run("                  
                        ALTER TABLE {$installer->getTable('sales_order_payment')}
                          MODIFY COLUMN last_trans_id VARCHAR(100); 
                    ");

        $installer->endSetup();
    }
}
