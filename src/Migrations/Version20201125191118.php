<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125191118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE response (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, value VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_3E7B0BFB1E27F6BF ON response (question_id)');
        $this->addSql('CREATE TABLE response_question_option (response_id INTEGER NOT NULL, question_option_id INTEGER NOT NULL, PRIMARY KEY(response_id, question_option_id))');
        $this->addSql('CREATE INDEX IDX_7F7C72CDFBF32840 ON response_question_option (response_id)');
        $this->addSql('CREATE INDEX IDX_7F7C72CDAE1159F4 ON response_question_option (question_option_id)');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, survey_id INTEGER DEFAULT NULL, question_type_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B6F7494EB3FE509D ON question (survey_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494ECB90598E ON question (question_type_id)');
        $this->addSql('CREATE TABLE tableau (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, diplome CLOB DEFAULT NULL, nb_places CLOB DEFAULT NULL, first_year CLOB DEFAULT NULL, second_year CLOB DEFAULT NULL, diplome_intermediaire CLOB DEFAULT NULL, third_year CLOB DEFAULT NULL, poursuite_etudes CLOB DEFAULT NULL, formation_et_concours CLOB DEFAULT NULL, vie_active CLOB DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE filiere (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, url_slug VARCHAR(255) DEFAULT NULL, candidate CLOB DEFAULT NULL, description CLOB DEFAULT NULL, title_block1 VARCHAR(255) DEFAULT NULL, text_block1 CLOB DEFAULT NULL, title_block2 VARCHAR(255) DEFAULT NULL, text_block2 CLOB DEFAULT NULL, title_block3 VARCHAR(255) DEFAULT NULL, text_block3 CLOB DEFAULT NULL, title_block4 VARCHAR(255) DEFAULT NULL, text_block4 CLOB DEFAULT NULL, title_block5 VARCHAR(255) DEFAULT NULL, text_block5 CLOB DEFAULT NULL, color_picker VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date_of_opening DATETIME NOT NULL, date_of_closure DATETIME NOT NULL, description VARCHAR(300) DEFAULT NULL)');
        $this->addSql('CREATE TABLE survey (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, event_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_AD5F9BFC71F7E88B ON survey (event_id)');
        $this->addSql('CREATE TABLE question_option (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5DDB2FB81E27F6BF ON question_option (question_id)');
        $this->addSql('CREATE TABLE question_option_response (question_option_id INTEGER NOT NULL, response_id INTEGER NOT NULL, PRIMARY KEY(question_option_id, response_id))');
        $this->addSql('CREATE INDEX IDX_DA851072AE1159F4 ON question_option_response (question_option_id)');
        $this->addSql('CREATE INDEX IDX_DA851072FBF32840 ON question_option_response (response_id)');
        $this->addSql('CREATE TABLE admin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, phone VARCHAR(20) NOT NULL, fax VARCHAR(20) NOT NULL, city VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE question_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, resume VARCHAR(255) DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_question_option');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE tableau');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE question_option');
        $this->addSql('DROP TABLE question_option_response');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE question_type');
    }
}
