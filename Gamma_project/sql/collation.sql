SELECT table_name, table_collation FROM information_schema.tables
WHERE table_schema = 'nome_da_base'

ALTER TABLE tablename CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

ALTER DATABASE dbname CHARACTER SET utf8 COLLATE utf8_general_ci;