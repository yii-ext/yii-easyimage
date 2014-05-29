<?php

/**
 * Class ImageAction
 */
class ImageAction extends CAction
{

    /**
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function run($params)
    {

        try {
            $eImage =Yii::app()->easyImage;
            //decrypt
            $params = @mcrypt_decrypt(MCRYPT_3DES, $eImage->password, $params, MCRYPT_MODE_ECB);
            $params = @unserialize(rtrim($params, "\0"));
            $imageLink = @$eImage->thumbSrcOf($params['f'], $params['p']);
            if (!empty($imageLink)) {
                header('Content-Type: image/jpeg');
                @readfile(Yii::app()->basePath . '/..' . $imageLink);
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
        Yii::log(serialize($_GET));
        $this->emptyImage();
        Yii::app()->end();
    }

    /**
     * Renders empty image
     */
    private function emptyImage()
    {
        header('Content-Type: image/png');
        echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
        Yii::app()->end();
    }


}