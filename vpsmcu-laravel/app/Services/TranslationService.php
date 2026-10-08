<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Common Buddhist & MCU academic glossary for high precision translation.
     */
    protected static array $customDictionary = [
        'มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย' => 'Mahachulalongkornrajavidyalaya University',
        'มหาจุฬาลงกรณราชวิทยาลัย' => 'Mahachulalongkornrajavidyalaya University',
        'สถาบันวิปัสสนาธุระ' => 'Vipassana Meditation Institute',
        'วิปัสสนากรรมฐาน' => 'Vipassana Meditation',
        'วิปัสสนาธุระ' => 'Vipassana Dhura',
        'กรรมฐาน' => 'Meditation Practice',
        'นิสิต มจร' => 'MCU Students',
        'มจร วังน้อย' => 'MCU Wang Noi',
        'มจร' => 'MCU',
        'วิทยาเขตเชียงใหม่' => 'Chiang Mai Campus',
        'วิทยาเขตขอนแก่น' => 'Khon Kaen Campus',
        'วิทยาเขตนครศรีธรรมราช' => 'Nakhon Si Thammarat Campus',
        'วิทยาเขตนครราชสีมา' => 'Nakhon Ratchasima Campus',
        'วิทยาเขตหนองคาย' => 'Nong Khai Campus',
        'วิทยาเขตแพร่' => 'Phrae Campus',
        'ปริญญาตรี' => 'Undergraduate',
        'บัณฑิตศึกษา' => 'Graduate Studies',
        'ปริญญาโท' => 'Master Degree',
        'ปริญญาเอก' => 'Doctoral Degree',
        'ประชาชนทั่วไป' => 'General Public',
        'ภาคประชาชน' => 'General Public',
    ];

    /**
     * Translate text from Thai to English.
     *
     * @param string|null $text
     * @return string|null
     */
    public static function translateToEnglish(?string $text): ?string
    {
        if (empty($text)) {
            return null;
        }

        // If text is already mostly English/ASCII, return as-is
        if (preg_match('/^[a-zA-Z0-9\s\p{P}]+$/u', trim($text))) {
            return trim($text);
        }

        try {
            // Chunk long text if needed (MyMemory allows up to 500 chars per query)
            $plainText = strip_tags($text);
            if (mb_strlen($plainText) > 400) {
                // Split by sentences or line breaks
                $paragraphs = preg_split('/(\r\n|\n|\r)/', $plainText, -1, PREG_SPLIT_NO_EMPTY);
                $translatedParts = [];
                foreach ($paragraphs as $para) {
                    $para = trim($para);
                    if (!empty($para)) {
                        $translatedParts[] = self::fetchTranslation($para);
                    }
                }
                $result = implode("\n\n", array_filter($translatedParts));
            } else {
                $result = self::fetchTranslation($plainText);
            }

            // Post-process with Buddhist MCU terminology glossary
            if (!empty($result)) {
                $result = self::applyGlossaryEnhancements($result);
                return $result;
            }
        } catch (\Throwable $e) {
            Log::warning('Auto-translation failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Perform HTTP request to free MyMemory API
     */
    protected static function fetchTranslation(string $chunk): ?string
    {
        $chunk = trim($chunk);
        if (empty($chunk)) {
            return null;
        }

        $url = 'https://api.mymemory.translated.net/get?q=' . urlencode($chunk) . '&langpair=th|en';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_USERAGENT, 'MCUVMS-Translator/1.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $data = json_decode($response, true);
            if (!empty($data['responseData']['translatedText'])) {
                $translated = html_entity_decode($data['responseData']['translatedText'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                // Check if MyMemory returned quota error string
                if (stripos($translated, 'MYMEMORY WARNING') === false) {
                    return trim($translated);
                }
            }
        }

        return null;
    }

    /**
     * Refine translations to match MCU university standards
     */
    protected static function applyGlossaryEnhancements(string $text): string
    {
        $replacements = [
            'Chulalongkorn University' => 'Mahachulalongkornrajavidyalaya University',
            'Chula' => 'MCU',
            'Vipassanathura Institute of Homelessness' => 'Vipassana Meditation Institute, MCU',
            'Vipassanathura Institute' => 'Vipassana Meditation Institute',
            'Vipassana Dhura Institute' => 'Vipassana Meditation Institute',
            'Vipassana business' => 'Vipassana Dhura',
            'Chulalongkorn University, Wang Noi' => 'Mahachulalongkornrajavidyalaya University, Wang Noi',
        ];

        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
}
