<?php

namespace option;

/*================================================================================
Class option
================================================================================*/

use Exception;

class option
{

    public string $name = "";
    public string $value = "";
    public string $quotation = "";

    /*--------------------------------------------------------------------
    construction
    --------------------------------------------------------------------*/

    public function __construct($name = "", $value = "")
    {
        $hasError = 0;
        try {
//            print('*********************************************************' . "\r\n");
//            print ("name: " . $name . "\r\n");
//            print ("value: " . $value . "\r\n");
//            print('---------------------------------------------------------' . "\r\n");

            $this->name = $name;
            //ToDo: $this->value = $this->assignValue (value); // remove '"' at start and end
            $this->value = $this->removeQuotation($value);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\r\n";
            $hasError = -101;
        }
//        // print('exit __construct: ' . $hasError . "\r\n");
    }

    private function removeQuotation(string $optionValuePart)
    {
        $optionValue = $optionValuePart;

        if ($optionValue != '') {
            $firstChar = $optionValuePart[0];
            if ($firstChar == '"' or $firstChar == "'") {
                $this->quotation = $firstChar;
                $optionValue = substr($optionValuePart, 1, -1);
            }
        }

        return $optionValue;
    }

    public function extractOptionFromString($inOptionsString = ""): option
    {
        $this->clear();

        try {
            $optionsString = Trim($inOptionsString);

            // single: /optionName or /optionName=value or /optionName="option value with spaces"

            //$optionName = '';
            $optionValue = '';

            $idx = strpos($optionsString, "=");

            // name without options
            if ($idx == false) {
                // Just name
                $optionName = substr($optionsString, 1);
            } else {
                // name with options
                $optionName = substr($optionsString, 1, $idx - 1);


                $optionValuePart = substr($optionsString, $idx + 1);
                $optionValue = $this->removeQuotation($optionValuePart);
            }

            $this->name = $optionName;
            $this->value = $optionValue;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage() . "\r\n";
            $hasError = -101;
        }

        return $this;
    }

    public function clear(): void
    {
        $this->name = '';
        $this->value = '';
    }

    public function text4Line(): string
    {
        $OutTxt = "/"; // . "\r\n";

        $OutTxt .= $this->name; // . "\r\n";
        if ($this->value == '' && $this->quotation != '') {
            $OutTxt .= "=" . $this->quotation . $this->value . $this->quotation;
        } else {
            if ($this->value != '') {
                if ($this->quotation == '') {
                    $OutTxt .= "=" . $this->value;
                } else {
                    $OutTxt .= "=" . $this->quotation . $this->value . $this->quotation;
                }
            }
        }

        return $OutTxt;
    }

    public function text(): string
    {
        $OutTxt = "------------------------------------------" . "\r\n";
        $OutTxt .= "--- option ---" . "\r\n";

        $OutTxt .= "name: " . $this->name . "\r\n";
        if ($this->quotation == '') {
            $OutTxt .= "value: " . "'" . $this->value . "'" . "\r\n";
        } else {
            $OutTxt .= "value: " . "'" . $this->quotation . $this->value . $this->quotation . "'" . "\r\n";
        }

        /**
         * $OutTxt .= "fileBaseName: " . $this->fileBaseName . "\r\n";
         * $OutTxt .= "filePath: " . $this->filePath . "\r\n";
         * $OutTxt .= "srcPathFileName: " . $this->srcPathFileName . "\r\n";
         * /**/

        return $OutTxt;
    }


} // option
