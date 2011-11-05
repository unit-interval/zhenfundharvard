<html>
    <body>
        <form action='admin.php' method='post'>
            <input type='text' name='passphrase' /><br />
            <input type='submit' name='show' />
            <input type='submit' name='reset' />
        </form>
<?php
if($_POST['passphrase'] == 'top-down') {
    include './config.php';
    include './database.php';

    $query = "select * from `judges` order by `id`";
    $result = $db->query($query);
    while($row = $result->fetch_assoc()) {
        echo $row['id'] . ": " . $row['passwd'] . "<br />";
    }
    $result->free();
}
?>
    </body>
</html>
