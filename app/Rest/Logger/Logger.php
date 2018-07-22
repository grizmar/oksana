<?php
/**
 * Created by PhpStorm.
 * User: tuman
 * Date: 2018-07-16
 * Time: 1:14
 */
namespace App\Rest\Logger;

use App\Helpers\DateFormatter;
use App\Helpers\Singleton;
use Illuminate\Support\Facades\App;
use Monolog\Logger as MonologLogger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use PolicyControl\Insys\LogCollection;
use PolicyControl\Logger\Message\LogMessageCollection;
use PolicyControl\Logger\Message\Message;
use Bitrix\Main\Config\Configuration;

/**
 * Class Logger
 * Класс для записи логов в файл
 * @package Qsoft\Rest\Api
 */
class Logger
{
    use Singleton;

    private const DIR = '/storage/logs/api/';
    private const FILE_NAME_TEMPLATE = 'log-{date-format}.log';

    /**
     * @const string шаблон сообщения
     */
    private const REQUEST_MESSAGE_TEMPLATE = '{instanse_id}]:[{service_name}]:[{error_code}]:[{error_message}]:[{debug}';
    private const LOG_FORMAT = "[%datetime%]:[%level_name%]:[%message%]\n";

    const DEBUG = MonologLogger::DEBUG;
    const INFO = MonologLogger::INFO;
    const NOTICE = MonologLogger::NOTICE;
    const WARNING = MonologLogger::WARNING;
    const ERROR = MonologLogger::ERROR;
    const CRITICAL = MonologLogger::CRITICAL;
    const ALERT = MonologLogger::ALERT;
    const EMERGENCY = MonologLogger::EMERGENCY;

    const DEBUG_LEVELS = [
        self::DEBUG     => true,
        self::INFO      => false,
        self::NOTICE    => false,
        self::WARNING   => false,
        self::ERROR     => true,
        self::CRITICAL  => true,
        self::ALERT     => true,
        self::EMERGENCY => true,
    ];

    /**
     * @var \Monolog\Logger (MonologLogger)
     */
    private $logHandler;

    /**
     * @var LogCollection
     */
    private $logCollection;

    /**
     * Logger constructor
     * Задание формата даты, сообщения и места сохранения
     */
    private function __construct()
    {
        $fileName = str_replace('{date-format}', date(DateFormatter::DATE_FORMAT), self::FILE_NAME_TEMPLATE);

        $this->logHandler = new MonologLogger($fileName);
        $streamHandler = new StreamHandler(storage_path('api/' . $fileName), MonologLogger::DEBUG);

        $formatter = new LineFormatter(self::LOG_FORMAT);
        $streamHandler->setFormatter($formatter);

        $this->logHandler->pushHandler($streamHandler);
        $this->logHandler->pushProcessor(new PsrLogMessageProcessor());

        $this->logCollection = LogCollection::getInstance();
    }

    private function getDebugInfoLimit()
    {
        $result = 3;
        if($result){
            $result = 10;
        }

        return $result;
    }

    private function getDebugInfo($level): string
    {
        return self::DEBUG_LEVELS[$level]
            ? json_encode(
                debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $this->getDebugInfoLimit()),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            )
            : '';
    }

    private function getContext($code, $message, $level)
    {
        return [
            'error_code'    => $code,
            'error_message' => $message,
            'debug'         => $this->getDebugInfo($level),
        ];
    }

    public function addRecord($messageKey, $replacement = [], $level = self::ERROR)
    {
        $message = LogMessageCollection::getInstance()->getMessage($messageKey, $replacement);

        $this->addMessageToCollection($message, $level);

        return $this->logHandler->addRecord(
            $level,
            self::REQUEST_MESSAGE_TEMPLATE,
            $this->getContext($message->getCode(), $message->getText(), $level)
        );
    }

    public function addMessage(Message $message, $replacement = [], $level = self::ERROR)
    {
        if(!empty($replacement)){
            $message->prepareText($replacement);
        }

        $this->addMessageToCollection($message, $level);

        return $this->logHandler->addRecord(
            $level,
            self::REQUEST_MESSAGE_TEMPLATE,
            $this->getContext($message->getCode(), $message->getText(), $level)
        );
    }
}