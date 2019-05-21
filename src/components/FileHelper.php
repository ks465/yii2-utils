<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 09/11/18
 * Time: 10:30
 */


namespace khans\utils\components;

use yii\base\BaseObject;

/**
 * make reading and writing file formats simpler
 *
 * @package khans\utils
 * @version 1.2.2-980226
 * @since   1.0
 */
class FileHelper extends BaseObject
{
    //<editor-fold Desc="csv">
    /**
     * Load data from CSV file into PHP array.
     * The first row is interpreted as element keys
     *
     * @param string    $fileURI URI to the CSV file
     * @param bool|true $associative should the result array be in associative format or not
     *
     * @return bool|array false if reading from file fails, or file content as array.
     */
    public static function loadCSV($fileURI, $associative = true)
    {
        $header = [];
        $out = [];
        $handle = fopen($fileURI, 'r');
        if ($handle === false) {
            return false;
        }
        $data = fgetcsv($handle, 0, ",");
        $data = StringHelper::trimAll($data);
        $data = StringHelper::correctYaKa($data);
        if ($associative) {
            $header = $data;
        }
        while ($data !== false) {
            $data = fgetcsv($handle, 0, ",");
            $data = StringHelper::trimAll($data);
            $data = StringHelper::correctYaKa($data);
            if (!empty($data)) {
                if ($associative) {
                    $out[] = array_combine($header, $data);
                } else {
                    $out[] = $data;
                }
            } else {
                break;
            }
        }
        fclose($handle);

        return $out;
    }

    /**
     * Save contents of an array to a CSV file
     *
     * @param string     $fileURI URI to the CSV file
     * @param array      $contents data to be saved as CSV
     *
     * @param null|array $header column titles for the file. If is empty, array keys of the first element of input
     *     content is used.
     *
     * @return bool|int false if writing fails, and number of rows written to file on success.
     */
    public static function saveCSV($fileURI, array $contents, $header = null)
    {
        $handle = fopen($fileURI, 'w');
        if ($handle === false) {
            return false;
        }
        if (empty($header)) {
            $header = array_keys(reset($contents));
        }
        fputcsv($handle, $header);

        $byteCounter = $rowCounter = 0;
        foreach ($contents as $index => $rowData) {
            $byteCounter += fputcsv($handle, $rowData);
            $rowCounter++;
        }

        fclose($handle);

        return $rowCounter;
    }
    //</editor-fold>

    //<editor-fold Desc="ini">
    /**
     * Load data from ini file into associative array
     *
     * @param string $fileURI URI to the CSV file
     *
     * @return array|bool
     */
    public static function loadIni($fileURI)
    {
        return parse_ini_file($fileURI, true);
    }
    //</editor-fold>
}
