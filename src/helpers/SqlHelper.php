<?php
namespace ancor\model\helpers;

/**
 * Some helpful functions for processing sql
 */
class SqlHelper
{

    /**
     * Escape like arguments.
     * Example: 'hello$ how% are' => 'hello\$ how\% are%'
     *
     * @param  array|string  $words like arguments
     * @param  integer       $limit slice the array, if it array
     * @param  string        $type  do concat '%' char? (start, end, both, none)
     *
     * @return array         ready items for where(['like',...])
     */
    public static function escapeLike($words, $limit = 4, $type = 'end')
    {
        /**
         * @var array
         */
        static $escaped = ['%' => '\%', '_' => '\_', '\\' => '\\\\'];

        if (empty($words)) return;

        // make array, if it's not array
        if ( ! is_array($words)) $words = [$words];

        // slice for limiting
        $words = array_slice($words, 0, $limit);

        $words = array_map(function ($word) use ($escaped, $type) {
            $escaped = strtr($word, $escaped); // escaping

            switch ($type) // adding '%'
            {
                case 'start': return "%$escaped";
                case 'end':   return "$escaped%";
                case 'both':  return "%$escaped%";

                default:case 'none':return "$escaped";
            }
        }, $words);

        return $words;
    } // end escapeLike()

    /**
     * Parse `like` query string. Split it by spaces and escape with help self::escapeLike
     * 
     * @param  string|NULL $query query string
     * @param  string      $delimiter   delimiter words(defaul ' ')
     * @param  string      $limit       limit of words number for process
     * @return array|null               array escaped words
     */
    public static function parseLikeQuery($query, $delimiter = ' ', $limit = 4)
    {
        if (empty($query)) return;

        $queryArr = explode($delimiter, $query, $limit);

        return self::escapeLike($queryArr, $limit);
    } // end parseLikeQuery()

}
