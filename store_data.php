<?php 
/**
 * @package Store data
 * @version 0
 */
/*
Plugin Name: Store data
Description: nothing special, just to store data
Author: Rafli
Version: 0
*/

function get_json_data() {
  $json_url = "https://github.com/rafliogun49/skripsi-rafli/blob/main/data_publications.json";
  $json_data = file_get_contents($json_url);
  $data_array = json_decode($json_data, true);
  return $data_array;
}

function generate_table($atts) {
  $data_array = get_json_data();

  if ($atts['category'] !== 'all') {
    $data_array = array_filter($data_array, function($item) use ($atts) {
        return $item['name'] === $atts['category'];
    });
}

  $html = '<table>';
  $html .= '<tr>';
  $html .= '<th>Judul Publikasi</th>';
  $html .= '<th>Tahun</th>';
  $html .= '<th>Cited by</th>';
  $html .= '<tr>';
  foreach ($data_array as $row) {
    $html .= '<tr>';
    $html .= '<td><a href='.$row["link"].'>'. $row["title"].'<a></td>';
    $html .= '<td>'.$row['year'].'<td>';
    $html .= '<td>'.$row['cited by'].'<td>';
    $html .= '</tr>';
  }
  $html .= '</table>';
  return $html;
}

function table_shortcode($atts) {
  $atts = shortcode_atts( array(
    'category' => 'all',
  ), $atts );
  $html = generate_table($atts);
  return $html;
}
add_shortcode('mytable', 'table_shortcode');
?>
