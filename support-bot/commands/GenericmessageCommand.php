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

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Commands\UserCommands\DonateCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Generic message command
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '0.2.0';

    /**
     * Execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $user_id = $message->getFrom()->getId();

        // Handle new chat members.
        if ($message->getNewChatMembers()) {
            $this->deleteThisMessage(); // Service message.
            return $this->getTelegram()->executeCommand('newchatmembers');
        }
        if ($message->getLeftChatMember()) {
            $this->deleteThisMessage(); // Service message.
        }

        // Handle successful payment of donation.
        if ($payment = $message->getSuccessfulPayment()) {
            return DonateCommand::handleSuccessfulPayment($payment, $user_id);
        }

        // Handle posts forwarded from channels.
        if ($message->getForwardFrom()) {
            return $this->getTelegram()->executeCommand('id');
        }

        return parent::execute();
    }

    /**
     * Delete the current message.
     *
     * @return ServerResponse
     */
    private function deleteThisMessage(): ServerResponse
    {
        return Request::deleteMessage([
            'chat_id'    => $this->getMessage()->getChat()->getId(),
            'message_id' => $this->getMessage()->getMessageId(),
        ]);
    }
}
