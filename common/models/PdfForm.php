<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PdfForm extends Model
{
    public $name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name'], 'integer'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * {@inheritdoc}
     */
}
