<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*

 * Excel library for Code Igniter applications

 * Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006

 */

function to_excel($query, $filename = 'exceloutput') {
    $headers = ''; // just creating the var for field headers to append to below
    $data = ''; // just creating the var for field data to append to below
    $obj = &get_instance();
    $fields = $query->field_data();
    if ($query->num_rows() == 0) {
        echo '<p>The table appears to have no data.</p>';
    } else {
        foreach ($fields as $field) {
            $headers .= $field->name . "\t";
        }
        foreach ($query->result() as $row) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value)) or ( $value == "")) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    // tweak
                    $tmp_value = $value;
                    $tmp_value = str_replace('""', '', $tmp_value);
                    if (is_numeric($tmp_value)) {
                        $value = str_replace('.', ',', $value);
                        $tmp_value = '';
                    } else {
                        $tmp_value = '';
                    }
                    // tweak
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }
        $data = str_replace("\r", "", $data);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=$filename.xls");
        header("Content-Description: AIS Data");
        echo "$headers\n$data";
    }
}

function dataarray_to_excel($headerArray, $dataArray, $filename = 'exceloutput') {
    $headers = ''; // just creating the var for field headers to append to below
    $data = ''; // just creating the var for field data to append to below
    $obj = &get_instance();
    if (count($dataArray) == 0) {
        echo '<p>The table appears to have no data.</p>';
    } else {
        foreach ($headerArray as $field) {
            $headers .= $field . "\t";
        }
        foreach ($dataArray as $row) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value)) or ( $value == "")) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    // tweak
                    $tmp_value = $value;
                    $tmp_value = str_replace('""', '', $tmp_value);
                    if (is_numeric($tmp_value)) {
                        $value = str_replace('.', ',', $value);
                        $tmp_value = '';
                    } else {
                        $tmp_value = '';
                    }
                    // tweak
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }
        $data = str_replace("\r", "", $data);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=$filename.xls");
        header("Content-Description: AIS Data");
        echo "$headers\n$data";
    }
}
