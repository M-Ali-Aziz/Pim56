<?php

namespace LucatBundle\Helper;

class Csv
{
    function output($rows, $filename)
    {
        set_time_limit(300);
        $exportFile = PIMCORE_SYSTEM_TEMP_DIRECTORY . "/lucat-export-" . uniqid() . ".csv";
        @unlink($exportFile);
        $fp = fopen($exportFile, 'w');
        fputcsv($fp, array_keys($rows[0]));
        foreach ($rows as $row) {
            fputcsv($fp, array_values($row));
        }
        fclose($fp);
        header('Content-type: text/csv; charset=UTF-8');
        header("Content-Length: " . filesize($exportFile));
        header("Content-Disposition: attachment; filename=\"" . $filename . ".csv\""); while (@ob_end_flush());
        flush();
        readfile($exportFile);
    }
}