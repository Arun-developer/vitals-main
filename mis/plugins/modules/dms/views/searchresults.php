<?php
$i = 0;
// Count hits
foreach ($aryResults as $value) {
    // Increase counter
    $i++;
}
echo '	<fieldset>' . "\n";
echo '    	<legend>Search Results</legend>' . "\n";
echo '<dl>' . "<br />\n";

// Check hits if they are files or directories
if (substr($pattern, -1, 1) == '/') {
    $echowhat = 'directories';
} else {
    $echowhat = 'files';
}
echo 'There are total of ' . $i . ' ' . $echowhat . ' matching the pattern "' . $pattern . '" in the selected path "' . $path . '".' . "<br />\n";
// Stop the timer
$endTime = microtime(true);
$timedblqecho = $endTime - $startTime;

// Print search time
echo 'This search took ' . $timedblqecho . ' seconds.' . "\n";
echo '</dl>' . "<br />\n";
echo '</fieldset>' . "\n";
echo '<fieldset class="action" style="text-align: left">' . "\n";
echo '    <input type=button class="button" value=" Back " onClick="history.go(-1)">' . "\n";
echo '</fieldset>' . "\n";
echo '</fieldset>' . "\n";
$i = 1;
foreach ($aryResults as $value) {
    echo $i . "<a href=" . host_url() . $value . ">" . host_url() . $value . "</a><br />\n";
    // Increase counter
    $i++;
}