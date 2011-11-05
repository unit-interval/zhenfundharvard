<html>
    <body>
        <form action='admin.php' method='post'>
            <input type='password' name='passphrase' /><br />
            <input type='submit' name='do' value='show' />
            <input type='submit' name='do' value='reset' />
        </form>
<?php
if($_POST['passphrase'] == 'top-down') {
    include './config.php';
    include './database.php';

    echo '<hr />';
    if($_POST['do'] == 'reset') {
        $db->query("truncate `votes`");
        echo "<p>successifully trancated table 'votes'.</p>";
    } elseif($_POST['do'] == 'show') {
        echo "<table><thead><tr><td>#</td><td>passwd</td></tr></thead><tbody>";
        $query = "select * from `judges` order by `id`";
        $result = $db->query($query);
        while($row = $result->fetch_assoc())
            echo "<tr><td>{$row['id']}</td><td>{$row['passwd']}</td></tr>";
        $result->free();
        echo "</tbody></table>";
    }
}
?>
    </body>
</html>
