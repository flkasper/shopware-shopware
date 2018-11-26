<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536234588UnitTranslation extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536234588;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE `unit_translation` (
              `unit_id` binary(16) NOT NULL,
              `language_id` binary(16) NOT NULL,
              `short_code` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
              `name` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
              `created_at` datetime(3) NOT NULL,
              `updated_at` datetime(3),
              PRIMARY KEY (`unit_id`,`language_id`),
              CONSTRAINT `fk.unit_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk.unit_translation.unit_id` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
