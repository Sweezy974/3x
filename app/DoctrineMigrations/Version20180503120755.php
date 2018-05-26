<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180503120755 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE place_advices RENAME INDEX fk_place_advices_place TO IDX_BCAFA563DA6A219');
        $this->addSql('ALTER TABLE place_advices RENAME INDEX fk_place_advices_user TO IDX_BCAFA563A76ED395');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1433D0605E237E06 ON place_categories (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B02345E237E06 ON city (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B0234550C01C2 ON city (zipcode)');
        $this->addSql('ALTER TABLE user_favorites RENAME INDEX fk_user_favorites_user_id TO IDX_E489ED11A76ED395');
        $this->addSql('ALTER TABLE user_favorites RENAME INDEX fk_user_favorites_place_id TO IDX_E489ED11DA6A219');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX fk_user_hobbies_list_third_category_id, ADD UNIQUE INDEX UNIQ_F5BF67A952287616 (third_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX fk_user_hobbies_list_second_category_id, ADD UNIQUE INDEX UNIQ_F5BF67A97BA301FC (second_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX fk_user_hobbies_list_first_category_id, ADD UNIQUE INDEX UNIQ_F5BF67A98CB39020 (first_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX fk_user_hobbies_list_user_id, ADD UNIQUE INDEX UNIQ_F5BF67A9A76ED395 (user_id)');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX fk_place_advices_photos_user_id TO IDX_A719281AA76ED395');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX fk_place_advices_photos_place_id TO IDX_A719281ADA6A219');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX fk_place_advices_photos_advice_id TO IDX_A719281A12998205');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CD5E237E06 ON place (name)');
        $this->addSql('ALTER TABLE place RENAME INDEX fk_place_city TO IDX_741D53CD8BAC62AF');
        $this->addSql('ALTER TABLE place RENAME INDEX fk_place_category TO IDX_741D53CD12469DE2');
        $this->addSql('ALTER TABLE place RENAME INDEX fk_place_user TO IDX_741D53CDA76ED395');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
        $this->addSql('ALTER TABLE user RENAME INDEX fk_user TO IDX_8D93D6498BAC62AF');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_2D5B02345E237E06 ON city');
        $this->addSql('DROP INDEX UNIQ_2D5B0234550C01C2 ON city');
        $this->addSql('DROP INDEX UNIQ_741D53CD5E237E06 ON place');
        $this->addSql('ALTER TABLE place RENAME INDEX idx_741d53cd12469de2 TO fk_place_category');
        $this->addSql('ALTER TABLE place RENAME INDEX idx_741d53cd8bac62af TO fk_place_city');
        $this->addSql('ALTER TABLE place RENAME INDEX idx_741d53cda76ed395 TO fk_place_user');
        $this->addSql('ALTER TABLE place_advices RENAME INDEX idx_bcafa563a76ed395 TO fk_place_advices_user');
        $this->addSql('ALTER TABLE place_advices RENAME INDEX idx_bcafa563da6a219 TO fk_place_advices_place');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX idx_a719281a12998205 TO fk_place_advices_photos_advice_id');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX idx_a719281aa76ed395 TO fk_place_advices_photos_user_id');
        $this->addSql('ALTER TABLE place_advices_photos RENAME INDEX idx_a719281ada6a219 TO fk_place_advices_photos_place_id');
        $this->addSql('DROP INDEX UNIQ_1433D0605E237E06 ON place_categories');
        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649C05FB297 ON user');
        $this->addSql('ALTER TABLE user RENAME INDEX idx_8d93d6498bac62af TO fk_user');
        $this->addSql('ALTER TABLE user_favorites RENAME INDEX idx_e489ed11a76ed395 TO fk_user_favorites_user_id');
        $this->addSql('ALTER TABLE user_favorites RENAME INDEX idx_e489ed11da6a219 TO fk_user_favorites_place_id');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX UNIQ_F5BF67A98CB39020, ADD INDEX fk_user_hobbies_list_first_category_id (first_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX UNIQ_F5BF67A97BA301FC, ADD INDEX fk_user_hobbies_list_second_category_id (second_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX UNIQ_F5BF67A952287616, ADD INDEX fk_user_hobbies_list_third_category_id (third_category_id)');
        $this->addSql('ALTER TABLE user_hobbies_list DROP INDEX UNIQ_F5BF67A9A76ED395, ADD INDEX fk_user_hobbies_list_user_id (user_id)');
    }
}
