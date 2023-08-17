<?php

/**
 * This file is part of the PHP Telegram Support Bot.
 *
 * (c) PHP Telegram Bot Team (https://github.com/php-telegram-bot)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace TelegramBot\SupportBot\Webhooks;

class Utils
{
    /**
     * Log the incoming webhook data.
     *
     * @param string $path
     */
    public static function logWebhookData(string $path): void
    {
        file_put_contents($path, sprintf(
            "%s\ninput:  %s\nGET:    %s\nPOST:   %s\nSERVER: %s\n\n",
            date('Y-m-d H:i:s'),
            file_get_contents('php://input'),
            json_encode($_GET),
            json_encode($_POST),
            json_encode($_SERVER)
        ), FILE_APPEND | LOCK_EX);
    }
}
