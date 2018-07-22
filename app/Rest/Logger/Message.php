<?php
/**
 * Created by PhpStorm.
 * User: tuman
 * Date: 2018-07-16
 * Time: 1:48
 */

namespace App\Rest\Logger;

class Message
{
    private $code;
    private $textTemplate;
    private $text;
    private $shortText = '';

    public function __construct($code, $textTemplate)
    {
        $this->code = $code;
        $this->textTemplate = $textTemplate;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getText(array $replacement = []): string
    {
        if(empty($this->text) && !empty($replacement)){
            $this->text = $this->prepareText($replacement);
        }

        return $this->text;
    }

    public function getShortText(): string
    {
        return $this->shortText;
    }

    private function prepareText(array $replacement = []): self
    {
        if(!empty($replacement)){
            $this->text = str_replace(array_keys($replacement), $replacement, $this->textTemplate);
        }

        return $this;
    }
}