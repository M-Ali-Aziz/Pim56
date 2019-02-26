<?php

namespace AppBundle\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Console\Dumper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
Use Pimcore\Db;

class DbCollationFixCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('dbcollation:fix')
            ->setDescription('Fix Db Collation - utf8mb4_swedish_ci');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            // DB connection
            $db = Db::get();

            $this->output->writeln('<info> Changing database/tabels CHARACTER to utf8mb4 and COLLATE to utf8mb4_swedish_ci </info>');
            $this->output->writeln('<info> Please wait ... </info>');

            // $sql = "SHOW VARIABLES LIKE 'collation%'";
            // $result = $db->fetchAll($sql);

            // // Get Database character_set and collation
            // // $sql1 = "SELECT @@character_set_database, @@collation_database";
            // $sql = "SELECT default_character_set_name, default_collation_name FROM information_schema.schemata WHERE schema_name = 'pimcore'";
            // $result = $db->fetchAll($sql);

            // Set Database CHARACTER and COLLATE
            $sql = "ALTER DATABASE pimcore CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci";
            $result = $db->query($sql)->execute();


            // Tables that needs to be ignored
            $ignoreTables = [];
            // Get all VIEWS and add to ignoreTables
            $sql = "SHOW FULL TABLES IN pimcore WHERE TABLE_TYPE LIKE 'VIEW'";
            $result = $db->fetchAll($sql);
            $ignoreTablesArr = array_map(function($v){ return $ignoreTables[] = $v['Tables_in_pimcore']; }, $result);
            // IgnoreTables
            $ignoreTables = array_push($ignoreTablesArr, 'assets', 'translations_admin','translations_website');
            $ignoreTables = $ignoreTablesArr;


            // // Get Table character_set and collation
            // $sql = "SHOW TABLE STATUS";
            // $sql = "SHOW TABLE STATUS LIKE 'documents'";
            // $result = $db->fetchAll($sql);

            // Set Table CHARACTER and COLLATE
            $sql = "SHOW TABLES";
            $result = $db->fetchAll($sql);
            foreach ($result as $table) {
                $t = $table['Tables_in_pimcore'];
                if (!in_array($t, $ignoreTables)) {
                    $sql = "ALTER TABLE $t CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci";
                    $result = $db->query($sql)->execute();
                }
            }


            $this->output->writeln('<info> Successfully changed database/tabels CHARACTER and COLLATE </info>');

            $this->output->writeln('<comment> OBS!!! Please go to:</comment>');
            $this->output->writeln('<comment> Admin-page > Settings > Data Objects > Classes </comment>');
            $this->output->writeln('<comment> and RESAVE all classes!!! </comment>');
            
        } catch (\Exception $e) {
            $this->output->writeln(sprintf('<error> %s </error>', $e->getMessage()));
        }        
    }
}