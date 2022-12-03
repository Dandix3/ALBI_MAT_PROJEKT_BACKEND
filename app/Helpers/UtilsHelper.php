<?php

namespace App\Helpers;

use App\Exceptions\ReportedException;
use App\Exceptions\ValidatorException;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Transliterator;

class UtilsHelper {

    private static $logger;

    /**
     * Method for normalize string to search.
     * Normalization contains these steps:
     *   - Remove all the diacritics
     *   - Lowercase the string
     *   - Unify all tolerated special characters into single one. Special
     *     characters are all whitespaces, hyphen and parenthesis
     *   - Remove tolerated characters form begging and end of the string.
     *   - Remove all other characters, except slash character. The slash
     *     character is used in machine product number and has very special
     *     meaning in S-Cloud.
     * @param string|null $string
     * @return string|null
     */
    public static function toNormSearch(?string $string): ?string {
        if (is_null($string)) {
            return null;
        }
        $norm = self::toUTF8($string);
        // remove diacritics
        //$norm = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $norm);
        $tl = Transliterator::create('ASCII;');
        $norm = $tl->transliterate($norm);
        $norm = strtolower($norm);
        $norm = preg_replace("/[\s\-()]+/", '-', $norm); // unify tolerated separators into one character
        $norm = preg_replace(["/^\-*/", "/\-*$/"], '', $norm); // remove tolerated characters (whitespace and so on) from both sides.
        $norm = preg_replace("/[^a-z0-9\/\-]/", '', $norm); // remove non-alphanumeric + tolerated char + slash char.
        return $norm;
    }

    public static function toUTF8(?string $string): string {
        return mb_convert_encoding($string ?? "", "UTF-8");
    }

    public static function getQueryParamIfExists(Request $request, string $param): ?string {
        if (array_key_exists($param, $request->getQueryParams())) {
            $parValue = $request->getQueryParams()[$param];
        } else {
            $parValue = null;
        }

        return $parValue;
    }

    public static function caseSensitiveImplodeAndUpperCase($string) {
        // case-sensitive split
        $pieces = preg_split('/(?=[A-Z])/', $string);
        // remove empty array elements
        $pieces = array_filter($pieces);
        $string = implode("_", $pieces);
        $string = strtoupper($string);
        return $string;
    }

    public static function getResponseArrayFormat(array $data, $count, $offset, $limit) {
        return response()->json(
            [
                "total" => $count,
                "offset" => intval($offset),
                "limit" => intval($limit),
                "data" => $data
            ]
        );
    }

    /**
     * Vygeneruje unikátní řetězec o délce 23 znaků a otestuje že neexistuje mezi stávajícími zákazníky.
     *
     * @return string
     * @throws Exception
     */
    public static function generateAccessCode() {
        return str_replace('.', '', uniqid("", true));
    }

    public static function getEntityClassNameNorm(object $obj) {
        $className = (new ReflectionClass($obj))->getShortName();
        $className = str_ireplace("entity", "", $className);
        $className = UtilsHelper::caseSensitiveImplodeAndUpperCase($className);
        return $className;
    }

    public static function unauthorizedResponseJson() {
        Log::debug('Returning Unauthorized: 401');
        return self::getResponse('Unauthorized', 401);
    }

    public static function permissionDeniedResponseJson(?Exception $exception) {
        if ($exception && $exception->getMessage()) {
            $message = $exception->getMessage();
        } else {
            $message = 'Permission denied';
        }
        return self::getResponse($message, 403);
    }

    public static function notFoundResponseJson($message = 'Not found') {
        return self::getResponse($message, 404);
    }

    public static function userAlreadyHasGameResponseJson($message = 'Už tuto hru přidanou máte') {
        return self::getResponse('Už tuto hru máte přidanou.', 409);
    }

    public static function duplicateObjectJson() {
        return self::getResponse('Duplicate object', 409);
    }

    public static function notImplementedResponseJson() {
        return self::getResponse('Not implemented', 501);
    }

    public static function validationErrorResponseJson(Exception $msg) {
        $err["validation_error"] = $msg->getMessage();
        $err["validation_exception"] = (new \ReflectionClass($msg))->getShortName();
        $err["additional_data"] = $msg->getAdditionalData();

        return self::getResponse($err, 400);
    }

    protected static function getResponse($mess, $code) {
        return response()->json([
            'status' => false,
            'message' => $mess
        ], $code);
    }

    /**
     * Method returns error message which is intended to be displayed to the end-user within the frontend
     *
     * Typical use case is typical error provided by backend (eg. duplicity violation etc.).
     *
     * @param ReportedException $msg User-based language specific error message
     * @return JsonResponse
     */
    public static function reportedErrorResponse(ReportedException $msg) {

        if (env('APP_DEBUG')) {
            $err["code"] = $msg->getCode();
            $err["file"] = $msg->getFile();
            $err["line"] = $msg->getLine();
            $err["trace"] = $msg->getTraceAsString();
        }

        return response()->json($msg->getMessage(), 409);
    }

    /**
     * Method parses from string to DateTime object, if string is supplied, and returns null if not able or throws Exception based on $breakOnError argument
     *
     * @param DateTime|string|null $datetime
     * @param bool $breakOnError If true, ValidatorException is thrown in case of invalid input, null is returned otherwise
     * @return DateTime|null
     * @throws ValidatorException
     */
    public static function parseDateTimeOrNull($datetime, $breakOnError = false) {
        if (empty($datetime)) {
            $datetime = null;
        }

        if (is_string($datetime)) {
            $datetime_origin = $datetime;
            $datetime = date_create($datetime);

            if ($datetime === false) {
                $error_msg = sprintf('Cannot parse date from string: "%s"', $datetime_origin);
                if ($breakOnError) {
                    throw new ValidatorException($error_msg);
                }

                $datetime = null;

                Log::warning($error_msg);
            }
        }

        if (!empty($datetime) && !is_a($datetime, DateTime::class)) {
            $error_msg = sprintf('DateTime object expected, type "%s" provided', gettype($datetime));

            if ($breakOnError) {
                throw new ValidatorException($error_msg);
            }

            $datetime = null;

            Log::warning($error_msg);
        }

        return $datetime;
    }

    public static function DateTimeToTimestampMicro(\DateTime $dateTime): int {

        if (!$dateTime instanceof Carbon) {
            $dateTime = new Carbon($dateTime);
        }

        return $dateTime->getTimestamp() * 1000 + ($dateTime->micro / 1000);
    }

    public static function TimestampMicroToDateTime(int $timestamp): \DateTime {

        $dateTime = new Carbon();
        $dateTime->setTimestamp(floor($timestamp / 1000))->addMicroseconds(($timestamp % 1000) * 1000);

        return $dateTime;
    }

    /**
     * Transform object attributes into array (with protected and private attributes)
     *
     * @param object $object
     * @param bool $recursive Transform also underlying objects to array
     * @return array
     * @throws ReflectionException
     */
    public static function objectToArray(object $object, $recursive = true) {
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $val = $property->getValue($object);
            $property->setAccessible(false);
            if (is_object($val) && $recursive) {
                if ($val instanceof DateTime) {
                    $val = $val->format("Y-m-d\TH:i:s.vP");
                } else {
                    $val = self::objectToArray($val);
                }
            }
            if (is_array($val)) {
                $arr = [];
                foreach ($val as $item) {
                    if (!is_object($item) || !$recursive) {
                        $arr[] = $item;
                        continue;
                    }

                    $arr[] = self::objectToArray($item);
                }
                $val = $arr;
            }
            $array[$property->getName()] = $val;
        }
        return $array;
    }

    /**
     * Method gets user based timezone setting, if not set, returns default application timezone setting
     *
     * @return \DateTimeZone
     */
    public static function getCustomUserTimezone(): \DateTimeZone {
        $tz = config("app.timezone");

        return new \DateTimeZone($tz);
    }

    /**
     * Method transforms string from camelCase to underscore_format
     * @param string $input
     * @return string
     */
    public static function fromCamelCaseToUnderscore(string $input): string {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Method transforms underscore string to camelCase
     *
     * @param string $string
     * @param false $capitalizeFirstCharacter
     * @return string
     */
    public static function underscoreToCamelCase($string, $capitalizeFirstCharacter = false) {

        $str = str_replace('_', '', ucwords($string, '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    /**
     * Method validates given date and prevents being in future related to current date and time
     *
     * @param DateTime $dateTime
     * @param int $toleranceInMinutes In case a tolerance is needed
     * @throws ValidatorException In case of date in future
     */
    public static function validateForFutureDate(\DateTime $dateTime, int $toleranceInMinutes = 0) {
        if ($dateTime) {
            if ($dateTime > new DateTime() && (new Carbon($dateTime))->diffInMinutes(new Carbon()) > $toleranceInMinutes) {
                throw new ValidatorException('Provided date is in future, please, check your date/time synchronization.');
            }
        }
    }

    public static function html2pdf(string $html) {
        $snappy = App::make('snappy.pdf');

        try {
            $output = $snappy->getOutputFromHtml($html);
        }
        catch (RuntimeException $e) {
            Log::error($e->getMessage(), $e->getTrace());
            throw new Exception('Nepodařilo se vygenerovat PDF, pravděpodobně chybí některá závislost v systému. Více viz log.');
        }

        return $output;
    }

}

