<?PHP
/* Copyright 2014, Bergware International.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */
?>
<?
foreach ($_POST as $key => $value) {
  if (!strlen($value)) continue;
  switch ($key) {
  case '#config':
    $config = $value;
    $options = '';
    break;
  case '#prefix':
    parse_str($value, $prefix);
    break;
  case 'service':
    $enable = $value;
    break;
  case 'exclude':
  case 'include':
    $list = explode(',', $value);
    foreach ($list as $insert) $options .= "-{$prefix[$key]} \"".str_replace(' ','\ ',trim($insert))."\" ";
    break;
  default:
    if ($key[0]!='#') $options .= (isset($prefix[$key]) ? "-{$prefix[$key]} " : "")."$value ";
    break;
  }
}
exec("/etc/rc.d/rc.checkmd5 stop > /dev/null");
$options = trim($options);
$keys['options'] = $options;
file_put_contents($config, $options);
if ($enable) shell_exec("/etc/rc.d/rc.checkmd5 start > /dev/null");
done();
?>
