<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-22
 * Time: 22:44
 */

namespace Tarre\Fortnox;


class FortnoxFileResponse
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @param bool $download
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function toResponse($download = false, $filename = 'Fortnox.pdf', $ContentType = 'application/pdf')
    {
        $response = response($this->response)
            ->header('Content-Type', $ContentType);
        if ($download) {
            $response->header('Content-Disposition', 'attachment; filename=' . $filename);
        }
        return $response;
    }

    /**
     * @param string $filename
     * @param string $ContentType
     * @return \Illuminate\Http\Response
     */
    public function download($filename = 'Fortnox.pdf', $ContentType = 'application/pdf')
    {
        return $this->toResponse(true, $filename, $ContentType);
    }


    /**
     * @param $filename
     * @param null $path
     * @return bool
     */
    public function save($filename, $path = null)
    {
        if (!$path) {
            $path = storage_path('fortnox');
        }
        if (!file_exists($path)) {
            mkdir($path);
        }
        $path = $path . DIRECTORY_SEPARATOR . $filename;

        $fh = fopen($path, 'w+');
        fwrite($fh, $this->response);
        fclose($fh);
        return file_exists($path);
    }

}
