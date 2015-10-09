<?php
namespace yii\easyii\models;

use Yii;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\helpers\Upload;

/**
 * @property integer $photo_id
 * @property integer $item_id
 * @property string $image_file
 * @property string $description
 * @property string $class
 *
 * @property string $image
*/
class Photo extends \yii\easyii\components\ActiveRecord
{
    const PHOTO_THUMB_WIDTH = 120;
    const PHOTO_THUMB_HEIGHT = 90;

    public static function tableName()
    {
        return 'easyii_photos';
    }

    public function rules()
    {
        return [
            [['class', 'item_id'], 'required'],
            ['item_id', 'integer'],
            ['image_file', 'image'],
            ['description', 'trim']
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className()
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Upload::getAbsolutePath($this->image_file));
    }

    public function getImage()
    {
        return Upload::getLink($this->image_file);
    }
}