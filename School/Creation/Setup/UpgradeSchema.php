<?php

namespace School\Creation\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.1') < 0) {

                        
        }

        
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
              $setup->startSetup();

        //$quote = 'quote';
        $orderTable = 'sales_order';
        $orderGridTable = 'sales_order_grid';

        //Order table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'school_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );
        $setup->getConnection()    
              ->addColumn(
                $setup->getTable($orderTable),
                'seller_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Seller Id'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'school_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Name'
                ]
            );
        $setup->getConnection()    
              ->addColumn(
                $setup->getTable($orderTable),
                'seller_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Seller Name'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderGridTable),
                'school_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );
        
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderGridTable),
                'seller_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Seller Id'
                ]
            );

          $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderGridTable),
                'school_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Name'
                ]
            );
        $setup->getConnection()    
              ->addColumn(
                $setup->getTable($orderGridTable),
                'seller_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Seller Name'
                ]
            );

    
        $setup->endSetup();
      
        }


        if (version_compare($context->getVersion(), '1.0.2', '<')) {
       $setup->startSetup();

        //$quote = 'quote';
        $school_table_information = 'school_information_table';
        //Order table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'phone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'fax',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );

          $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'address',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );

              $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'state',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );


               $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'zipcode',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );


             $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );


             $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'typeoffund',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );

             $setup->getConnection()
            ->addColumn(
                $setup->getTable($school_table_information),
                'comment',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'School Id'
                ]
            );

        $setup->endSetup();

        }




    }
}
