<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    
    public $image;

    private $uploadsFolder;

    public function __construct()
    {
        $this->uploadsFolder = Yii::getAlias('@web') . 'uploads/';
    }
    
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,jpeg,png'],
        ];
    }
    
    /**
     * Saves the image file on the server in directory app/web/uploads.
     * 
     * @return string Name of newly saved image.
     */
    public function uploadFile(UploadedFile $file, ?string $currentImage)
    {
        $this->image = $file;

        if (!$this->validate()) {
            return '';
        }

        // Delete current image.
        $this->deleteFile($currentImage);

        // Generate file name.
        $this->image->name = md5(uniqid($this->image->basename)) . '.' . $this->image->extension;

        // Save image.
        $this->image->saveAs($this->uploadsFolder . $this->image->name);

        return $this->image->name;
    }

    public function deleteFile(?string $file)
    {
        if ($file && file_exists($this->uploadsFolder . $file)) {
            unlink($this->uploadsFolder . $file);
        }
    }

}
