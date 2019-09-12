<?php
class ControllerExtensionModuleDocument extends Controller {

    public function download() {

        if (file_exists('image/'.$this->request->get['filename'])) {
            $file = 'image/'.$this->request->get['filename'];
        } else {
            $file = !empty($this->request->get['eleres']) ? $this->request->get['eleres'] : DIR_DOWNLOAD . $this->request->get['filename'];
        }

        if (!headers_sent()) {
            if (file_exists($file)) {



                $filename = 'Custom file name for the.pdf'; /* Note: Always use .pdf at the end. */

                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $filename . '"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($file));
                header('Accept-Ranges: bytes');

                @readfile($file);

                /*header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file). '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));

                if (ob_get_level()) {
                    ob_end_clean();
                }

                readfile($file, 'rb');*/

                exit();
            } else {
                exit('Error: Could not find file ' . $file . '!');
            }
        } else {
            exit('Error: Headers already sent out!');
        }

    }
}