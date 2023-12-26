<?php /*ěščřžýáíéúů*/
/*
Template Name: Text page template
Template Post Type: page
*/

the_post();
get_header();
?>

<h1>Heading H1</h1>

<p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<h2>Heading H2</h2>
<p>Lorem ipsum <a href="#">dolor sit amet</a>, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<h3>Heading H3</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipisici elit, <strong>sed eiusmod tempor</strong> incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<ul>
    <li>Lorem ipsum dolor sit amet, consectetur adipisici elit.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.</li>
    <li>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
    <li>Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
</ul>

<h4>Heading H4</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<ol>
    <li>Lorem ipsum dolor sit amet, consectetur adipisici elit.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.</li>
    <li>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
    <li>Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
    <li>Lorem ipsum dolor sit amet, consectetur adipisici elit.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.</li>
    <li>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
    <li>Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
    <li>Lorem ipsum dolor sit amet, consectetur adipisici elit.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.</li>
    <li>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
    <li>Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
</ol>

<p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<a href="images/image-template.png"><img src="images/image-template.png" alt=" " title=" " /></a>

<h5>Heading H5</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<?php
$tableColumnsCount = 5;
$tableRowsCount = 5;
?>
<table>
    <thead>
        <tr>
            <?php for ($i = 1; $i <= $tableColumnsCount; $i++) : ?>
            <th>Table heading</th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($row = 1; $row <= $tableRowsCount; $row++) : ?>
        <tr>
            <?php for ($i = 1; $i <= $tableColumnsCount; $i++) : ?>
            <td>Lorem ipsum dolor sit amet, consectetur adipisici elit.</td>
            <?php endfor; ?>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>

<?php
get_footer();
?>