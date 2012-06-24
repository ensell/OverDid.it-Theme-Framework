<?php
/**
 * Display page output
 *
 * Take meta data in and output column portions
 *
 * @category   Parent
 * @package    WordPress
 * @copyright  Copyright (c) 2011 OverDid.it
 * @license    http://www.gnu.org/licenses/gpl.html   GPLv3
 * @version    0.1
 * @since      2.0
 */
class overdid_column
{
    private $_data;

    function __construct( $data )
    {
        $this->_data = $data;
    }

    /**
     * Display header for column
     * @param string $num - The meta number to use
     */
    function header( $num )
    {
        return $this->_data[ 'content' . $num . '_header' ];
    }

    /**
     * Display Sub Header for Column
     * @param string $num - The meta number to use
     */
    function sub_header( $num )
    {
        return $this->_data[ 'content' . $num . '_sub_head' ];
    }

    /**
     * Display the image for the column
     * @param string $num - The meta number to use
     * @param string $classes - optional CSS classes
     */
    function image( $num, $classes = "" )
    {
        $return = "<img src='";
        $return .= $this->_data[ 'content' . $num . '_image' ];
        $return .= "' alt='";
        $return .= $this->_data[ 'content' . $num . '_header' ];
        if ( $classes ) :
            $return .= "' class='";
            $return .= $classes;
        else : endif;
        $return .= "' />\r\n";

        return $return;
    }

    function image_link( $num )
    {
        return $this->_data[ 'content' . $num . '_image' ];
    }

    /**
     * Display the column comment
     * @param string $num - The meta number to use
     */
	function content( $num )
	{
		return $this->_data[ 'content' . $num . '_content' ];
	}

	function link( $num )
	{
		if( $this->_data[ 'content' . $num . '_link' ] !== "" )
			return get_permalink( $this->_data[ 'content' . $num . '_link' ] );
		else
			return $this->_data[ 'content' . $num . '_link_get' ];
	}
	function link_text( $num )
	{
		return $this->_data[ 'content' . $num . '_link_text' ];
	}

    /**
     *  Function:   convert_number
     *
     *  Description:
     *  Converts a given integer (in range [0..1T-1], inclusive) into
     *  alphabetical format ("one", "two", etc.)
     *
     * @int
     *
     * @return string
     *
     */
    function convert_number( $number )
    {
        $gn = floor( $number / 1000000 ); /* Millions (giga) */
        $number -= $gn * 1000000;
        $kn = floor( $number / 1000 ); /* Thousands (kilo) */
        $number -= $kn * 1000;
        $hn = floor( $number / 100 ); /* Hundreds (hecto) */
        $number -= $hn * 100;
        $dn = floor( $number / 10 ); /* Tens (deca) */
        $n = $number % 10; /* Ones */

        $res = "";

        if ( $gn ) {
            $res .= convert_number( $gn ) . " Million";
        }

        if ( $kn ) {
            $res .= ( empty( $res ) ? "" : " " ) .
            convert_number( $kn ) . " Thousand";
        }

        if ( $hn ) {
            $res .= ( empty( $res ) ? "" : " " ) .
            convert_number( $hn ) . " Hundred";
        }

        $ones = array( "", "One", "Two", "Three", "Four", "Five", "Six",
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen" );
        $tens = array( "", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
            "Seventy", "Eigthy", "Ninety" );

        if ( $dn || $n ) {
            if ( !empty( $res ) ) {
                $res .= " and ";
            }

            if ( $dn < 2 ) {
                $res .= $ones[ $dn * 10 + $n ];
            } else {
                $res .= $tens[ $dn ];

                if ( $n ) {
                    $res .= "-" . $ones[ $n ];
                }
            }
        }

        if ( empty( $res ) ) {
            $res = "zero";
        }

        return $res;
    }

}