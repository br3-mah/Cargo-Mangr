<?php
namespace App\Traits;

use App\Models\TwilioSetting;

trait Twilio
{
    /**
     * Send a message to multiple recipients using raw cURL and Twilio.
     *
     * @param array $recipients Array of phone numbers (E.164 format)
     * @param string $message SMS body
     * @return array Response per number
     */
    public function sendBulkSms(array $recipients, string $message): array
    {
        $twilio = TwilioSetting::first();

        if (!$twilio || !$twilio->enabled) {
            return ['error' => 'Twilio is not enabled or not configured.'];
        }

        $responses = [];

        foreach ($recipients as $to) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/{$twilio->account_sid}/Messages.json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'To' => $to,
                'From' => $twilio->from_number,
                'Body' => $message,
            ]));
            curl_setopt($ch, CURLOPT_USERPWD, $twilio->account_sid . ":" . $twilio->auth_token);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            if ($curlError) {
                $responses[$to] = [
                    'status' => 'error',
                    'error' => $curlError,
                ];
            } elseif ($httpCode >= 200 && $httpCode < 300) {
                $responseJson = json_decode($result, true);
                $responses[$to] = [
                    'status' => 'sent',
                    'sid' => $responseJson['sid'] ?? null,
                    'body' => $responseJson['body'] ?? null,
                ];
            } else {
                $responses[$to] = [
                    'status' => 'failed',
                    'response' => $result,
                    'http_code' => $httpCode,
                ];
            }
        }

        return $responses;
    }
}