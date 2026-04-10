<?php
function num_decline( $number, $titles, $show_number = true ){

if( is_string( $titles ) ){
    $titles = preg_split( '/, */', $titles );
}

// когда указано 2 элемента
if( empty( $titles[2] ) ){
    $titles[2] = $titles[1];
}

$cases = [ 2, 0, 1, 1, 1, 2 ];

$intnum = abs( (int) strip_tags( $number ) );

$title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
    ? 2
    : $cases[ min( $intnum % 10, 5 ) ];

return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
}
function translateTime($number) {
    $arr = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
      ];
    return $arr[$number - 1];      
}
?>