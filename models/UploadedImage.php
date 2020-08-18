<?php

namespace app\models;

use yii\base\Model;

class UploadedImage extends Model
{
	public $image;

	public function __construct($file)
	{
		parent::__construct();
		$this->image = $file;
	}

	public function saveImage($imageFolder)
	{
		$newName = $this->generateName();
		$this->image->saveAs($imageFolder . $newName);

		return $newName;
	}

	private function generateName()
	{
		return strtolower(md5(uniqid($this->image->baseName)) .'.'. $this->image->extension);
	}
}