<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536234606SalesChannelPaymentMethod extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536234606;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE `sales_channel_payment_method` (
              `sales_channel_id` binary(16) NOT NULL,
              `payment_method_id` binary(16) NOT NULL,
              `created_at` datetime(3) NOT NULL,
              `updated_at` datetime(3),
              PRIMARY KEY (`sales_channel_id`, `payment_method_id`),
              CONSTRAINT `fk.sales_channel_payment_method.sales_channel_id` FOREIGN KEY (`sales_channel_id`) REFERENCES `sales_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk.sales_channel_payment_method.payment_method_id` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
