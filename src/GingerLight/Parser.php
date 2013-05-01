<?php

namespace GingerLight;

use Guzzle\Http\Client;

/**
 * Parser.
 *
 * @package GingerLight
 * @author  Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class Parser
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl = 'http://services.gingersoftware.com/Ginger/correct/json/GingerTheText';

    /**
     * @var array
     */
    protected $parameters = array(
        'api_version' => '2.0',
        'lang'        => 'US',
        'api_key'     => '6ae0c3a0-afdc-4532-a810-82ded0054236'
    );

    /**
     * __construct
     * 
     * @param string $url
     * @param array  $parameters
     */
    public function __construct($baseUrl = null, array $parameters = null)
    {
        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }

        if ($parameters) {
            $this->parameters = array_merge($this->params, $parameters);
        }
        
        $query = http_build_query(
            array(
                'clientVersion' => $this->parameters['api_version'],
                'lang'          => $this->parameters['lang'],
                'apiKey'        => $this->parameters['api_key'],
            )
        );

        $this->client = new Client($this->baseUrl.'?'.$query);
    }

    /**
     * parse
     * 
     * @param  string $text
     * 
     * @return array
     */
    public function parse($text)
    {
        $request = $this->client->get();
        $request->getQuery()->set('text', $text);

        $data = $request->send()->json();
        return $this->processSuggestions($text, $data);
    }

    /**
     * processSuggestions
     * 
     * @param  string $text
     * @param  array  $data
     * 
     * @return array
     */
    protected function processSuggestions($text, array $data)
    {
        $result      = '';
        $corrections = array();
        $i           = 0;

        foreach ($data['LightGingerTheTextResult'] as $lightGinger) {
            $start = $lightGinger["From"];
            $end   = $lightGinger["To"];
            $suggestion = $lightGinger['Suggestions'][0];

            if ($i <= $end) {
                if ($start != 0) {
                    $result .= substr($text, $i, $start-$i);
                }
                $result .= $suggestion['Text'];
                $corrections[] = array(
                    "text"       => substr($text, $start, ($end+1)-$start),
                    "correct"    => !empty($suggestion['Text']) ? $suggestion['Text']:'',
                    "definition" => !empty($suggestion['Definition']) ? $suggestion['Definition']:'',
                    "start"      => $start,
                    "length"     => ($end+1)-$start,
                );
            }
            $i = $end + 1;
        }

        if ($i < strlen($text)) {
            $result .= substr($text, $i);
        }

        return array('text'=> $text, 'result'=> $result, 'corrections'=> $corrections);
    }
}