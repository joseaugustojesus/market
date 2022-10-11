<?php

namespace app\core;

use Shuchkin\SimpleXLSX;

class Uploader
{

    private static $file_ = null;
    private static $destiny = null;
    private static $maximumSize = null;
    private static $allowed = null;


    static function upload()
    {

        if (self::$file_) {
            [$tmpPath, $tmpFilename, $tmpSize, $tmpType] = self::getInfo(self::$file_);

            if (self::$maximumSize) {
                if ($tmpSize > self::$maximumSize) {
                    return [
                        'status' => 500,
                        'message' => 'The file has exceeded the allowed size'
                    ];
                }
            }


            $infoExploded = explode(".", $tmpFilename);
            $fileExtension = strtolower(end($infoExploded));
            $newFileName = md5(time() . $tmpFilename) . '.' . $fileExtension;


            if (in_array($fileExtension, self::$allowed)) {
                $destinyPath = './public/uploads/' . self::$destiny . "/{$newFileName}";

                if (move_uploaded_file($tmpPath, $destinyPath)) {
                    return [
                        'status' => 200,
                        'message' => 'File is successfully uploaded',
                        'filePath' => $destinyPath
                    ];
                } else {
                    return [
                        'status' => 500,
                        'message' => 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.'
                    ];
                }
            } else {
                return [
                    'status' => 500,
                    'message' => 'The file type is not allowed'
                ];
            }
        }

        return [
            'status' => 500,
            'message' => 'Need to inform the upload file'
        ];
    }



    static function getInfo($file)
    {
        return [
            $file['tmp_name'],
            $file['name'],
            $file['size'],
            $file['type']
        ];
    }



    static function setFile($file)
    {
        self::$file_ = $file;
    }

    static function setDestiny($destiny)
    {
        self::$destiny = $destiny;
    }

    static function setAllowed($allowed)
    {
        self::$allowed = $allowed;
    }

    static function setMaximumSize($max)
    {
        self::$maximumSize = $max;
    }


    /**
     * This method reads the file and creates an array where the positions are the columns of the file
     *
     * @param string $filepath
     * @return array|null
     */
    static function readXlsxOnlyRowsWithHeaderAsIndex(string $filepath)
    {
        if ($xlsx = SimpleXLSX::parse($filepath)) {
            // Produce array keys from the array values of 1st array element
            $header_values = $rows = [];
            foreach ($xlsx->rows() as $k => $r) {
                if ($k === 0) {
                    $header_values = array_slugify($r);
                    continue;
                }
                $rows[] = array_combine($header_values, $r);
            }
            return $rows;
        } else {
            // echo SimpleXLSX::parseError();
            return null;
        }
    }
}
