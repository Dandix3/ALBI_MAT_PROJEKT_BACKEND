<?php


namespace App\Exceptions;


use Exception;

class ValidatorException extends Exception {
    protected $additionalData = [];

    /**
     * Method sets additional data to the exception
     *
     * @param array $data
     * @return $this
     */
    public function setAdditionalData(array $data) {
        $this->additionalData = $data;
        return $this;
    }

    /**
     * Method gets additional data from the exception
     *
     * @return array
     */
    public function getAdditionalData(): array {
        return $this->additionalData;
    }
}
