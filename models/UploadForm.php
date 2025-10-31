<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $picture;
    public $csv;

    public function rules()
    {
        return [
            [['picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg'],
            [['csv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    public function upload($id)
    {
        if ($this->picture->saveAs('images/' . $id . '.' . $this->picture->extension)) {
            return true;
        } else {
            return false;
        }
    }
}

